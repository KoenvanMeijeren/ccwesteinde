<?php


namespace App\model\reservation;

use App\contracts\models\reservation\ReservationModel;
use App\model\admin\account\User;
use App\model\admin\page\Slug;
use App\model\admin\settings\Settings;
use App\model\admin\workspace\Workspace;
use App\services\core\Mail;
use App\services\core\Request;
use App\services\core\Router;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\exceptions\CustomException;
use App\services\session\Session;
use Cake\Chronos\Chronos;

class Reservation implements ReservationModel
{
    /**
     * The half hour option in the form
     *
     * @var float
     */
    const HALF_HOUR_OPTION = 0.5;

    /**
     * The 1 hour option in the form
     *
     * @var int
     */
    const ONE_HOUR_OPTION = 1;

    /**
     * The one and half hours option in the form.
     *
     * @var float
     */
    const ONE_AND_HALF_HOURS_OPTIONS = 1.5;

    /**
     * The two hours option in the form
     *
     * @var int
     */
    const TWO_HOURS_OPTION = 2;

    /**
     * The id of the workspace slug
     *
     * @var int
     */
    private $workspaceSlugID = 9;

    /**
     * The id of the meeting room slug
     *
     * @var int
     */
    private $meetingRoomSlugID = 10;

    /**
     * The id of the reservation
     *
     * @var int
     */
    protected $id;

    /**
     * The user id.
     *
     * @var int
     */
    protected $userID;

    /**
     * The workspace id.
     *
     * @var int
     */
    protected $workspaceID;

    /**
     * The kind of the reservation
     *
     * @var int
     */
    private $kind;

    /**
     * The date of the reservation
     *
     * @var string
     */
    private $date;

    /**
     * The time of the reservation
     *
     * @var string
     */
    private $time;

    /**
     * The day part of the reservation
     *
     * @var string
     */
    private $dayPart;

    /**
     * The duration of the reservation
     *
     * @var string
     */
    private $duration;

    /**
     * The start datetime of the reservation
     *
     * @var string
     */
    protected $startDateTime;

    /**
     * The end datetime of the reservation
     *
     * @var string
     */
    protected $endDateTime;

    /**
     * Construct the reservation
     */
    public function __construct()
    {
        $request = new Request();
        $user = new User();

        $this->id = intval(Router::getWildcard());
        $this->userID = $user->getID();
        $this->workspaceID = intval($request->post('workspace'));

        // set the kind
        $this->kind = intval($request->get('kind'));
        if (empty($this->kind)) {
            $this->kind = intval($request->post('kind'));
        }

        // set the start date
        $this->date = $request->get('date');
        if (empty($this->date)) {
            $this->date = $request->post('date');
        }
        if (!validateDate($this->date, 'd-m-Y')) {
            $this->date = null;
        }

        // set the time
        $this->time = $request->get('time');
        if (empty($this->time)) {
            $this->time = $request->post('time');
        }
        if (!validateDate($this->time, 'H:i')) {
            $this->time = null;
        }

        // set the day part or the duration
        if ($this->getKind() === 'werkplek') {
            $this->dayPart = $request->get('dayPart');
            if (empty($this->dayPart)) {
                $this->dayPart = $request->post('dayPart');
            }
        } elseif ($this->getKind() === 'vergaderruimte') {
            $this->duration = floatval($request->get('duration'));
            if (empty($this->duration)) {
                $this->duration = floatval($request->post('duration'));
            }
        }

        if (empty($this->duration)) {
            if ($this->dayPart === 'morning') {
                $workspaceStartDate = new Chronos($this->date . '00:00:00');
                $this->startDateTime = $workspaceStartDate->toDateTimeString();

                $workspaceEndDate = new Chronos($this->date . '11:59:59');
                $this->endDateTime = $workspaceEndDate->toDateTimeString();
            } elseif ($this->dayPart === 'afternoon') {
                $workspaceStartDate = new Chronos($this->date . '12:01:01');
                $this->startDateTime = $workspaceStartDate->toDateTimeString();

                $workspaceEndDate = new Chronos($this->date . '23:59:59');
                $this->endDateTime = $workspaceEndDate->toDateTimeString();
            }
        }

        if (empty($this->dayPart)) {
            $this->setDuration();
        }
    }

    /**
     * Calculate the occupancy rating of the workspaces at a specific day.
     *
     * @param Chronos $date                The date to ge the reservations for.
     * @param int     $maximumReservations The maximum of reservation per worksspace.
     *
     * @return float|int
     */
    public function calculateWorkspaceOccupancyRating(Chronos $date, int $maximumReservations = 1)
    {
        $request = new Request();
        $slug = new \App\model\admin\page\Slug(0, $request->get('space'));

        $workspaceReservations = $this->getAllByDate(
            $slug->id,
            $date->toDateString() . ' 00:00:00',
            $date->toDateString() . ' 23:59:59'
        );

        $occupancyRating = intval($workspaceReservations->workspace_reservation_quantity ?? 0);
        $occupancyRating = $occupancyRating / intval($maximumReservations);
        $occupancyRating = intval(number_format($occupancyRating * 100, 0));

        return $occupancyRating;
    }

    /**
     * Calculate the occupancy rating of the meeting rooms at a specific day.
     *
     * @param Chronos $date The date to get the reservations for.
     *
     * @return float|int
     */
    public function calculateMeetingRoomOccupancyRating(Chronos $date)
    {
        $request = new Request();
        $workspace = new Workspace();
        $settings = new Settings();
        $slug = new \App\model\admin\page\Slug(0, $request->get('space'));

        $workspace->setSlugID($slug->id);
        $workspaces = $workspace->getAllBySlug();

        $workspaceReservations = $this->getAllMeetingRoomReservationsByDate(
            $slug->id,
            $date->toDateString() . ' 00:00:00',
            $date->toDateString() . ' 23:59:59'
        );

        $openingHour = new Chronos($settings->get('schoolOpeningHour'));
        $closingHour = new Chronos($settings->get('schoolClosingHour'));

        $maximumFilledMinutes = $closingHour->diffInMinutes($openingHour) * count($workspaces);
        $filledMinutes = 0;
        if (!empty($workspaceReservations) && is_array($workspaceReservations)) {
            foreach ($workspaceReservations as $workspaceReservation) {
                $reservationStartDate = new Chronos($workspaceReservation->workspace_reservation_start_datetime ?? '');
                $reservationEndDate = new Chronos($workspaceReservation->workspace_reservation_end_datetime ?? '');

                $filledMinutes += $reservationEndDate->diffInMinutes($reservationStartDate);
            }
        }

        $occupancyRating = $filledMinutes / $maximumFilledMinutes;
        $occupancyRating = intval(number_format($occupancyRating * 100, 0));

        return $occupancyRating;
    }

    /**
     * Calculate the occupancy rating of a workspace
     *
     * @param array $reservations All the reservation by the workspace
     *
     * @return float|int
     */
    public function calculateOccupancyRatingByWorkspace(array $reservations)
    {
        $request = new Request();
        $settings = new Settings();

        if ($request->get('space') === 'vergaderruimte') {
            $openingHour = new Chronos($settings->get('schoolOpeningHour'));
            $closingHour = new Chronos($settings->get('schoolClosingHour'));

            $maximumFilledMinutes = $closingHour->diffInMinutes($openingHour);
            $filledMinutes = 0;
            if (!empty($reservations) && is_array($reservations)) {
                foreach ($reservations as $reservation) {
                    $reservationStartDate = new Chronos($reservation->workspace_reservation_start_datetime ?? '');
                    $reservationEndDate = new Chronos($reservation->workspace_reservation_end_datetime ?? '');

                    $filledMinutes += $reservationEndDate->diffInMinutes($reservationStartDate);
                }
            }

            $occupancyRating = $filledMinutes / $maximumFilledMinutes;
            $occupancyRating = intval(number_format($occupancyRating * 100, 0));

            return $occupancyRating;
        } elseif ($request->get('space') === 'werkplek') {
            $occupancyRate = count($reservations);
            $occupancyRate = intval(
                number_format(($occupancyRate / 2) * 100, 0)
            );

            return $occupancyRate;
        }

        return 0;
    }

    /**
     * Get the reservation.
     *
     * @return object
     */
    public function get()
    {
        $reservation = DB::table('workspace_reservation', 2)
            ->select(
                'workspace_reservation_ID',
                'workspace_reservation_user_ID',
                'account_name',
                'account_email',
                'workspace_reservation_workspace_ID',
                'workspace_slug_ID',
                'workspace_name',
                'workspace_reservation_start_datetime',
                'workspace_reservation_end_datetime',
                'workspace_reservation_accepted'
            )
            ->innerJoin('workspace', 'workspace_reservation_workspace_ID', 'workspace_ID')
            ->innerJoin('account', 'workspace_reservation_user_ID', 'account_ID')
            ->where('workspace_reservation_ID', '=', $this->id)
            ->where('workspace_reservation_accepted', '=', 1)
            ->where('workspace_reservation_is_deleted', '=', 0)
            ->where('account_is_deleted', '=', 0)
            ->where('workspace_is_deleted', '=', 0)
            ->execute()
            ->first();

        return $reservation;
    }

    /**
     * Get the reservation by workspace and datetime.
     *
     * @param int $workspaceID The id of the workspace.
     *
     * @return object
     */
    public function getByWorkspaceAndDateTime(int $workspaceID = 0)
    {
        if (!empty($workspaceID)) {
            $this->workspaceID = $workspaceID;
        }

        $reservation = DB::table('workspace_reservation', 1)
            ->select('workspace_reservation_ID', 'account_email')
            ->innerJoin('account', 'workspace_reservation_user_ID', 'account_ID')
            ->where('account_is_deleted', '=', 0)
            ->where('workspace_reservation_workspace_ID', '=', $this->workspaceID)
            ->where('workspace_reservation_start_datetime', '=', $this->startDateTime)
            ->where('workspace_reservation_end_datetime', '=', $this->endDateTime)
            ->where('workspace_reservation_is_deleted', '=', 0)
            ->where('workspace_reservation_accepted', '=', 1)
            ->execute()
            ->first();

        return $reservation;
    }

    /**
     * Get the reservation by workspace and between the start or end datetime.
     *
     * @param int $workspaceID The id of the workspace.
     *
     * @return object
     */
    public function getByWorkspaceInBetweenStartOrEndDateTime(int $workspaceID = 0)
    {
        if (!empty($workspaceID)) {
            $this->workspaceID = $workspaceID;
        }

        $reservation = DB::table('workspace_reservation', 1)
            ->select('workspace_reservation_ID', 'account_email')
            ->innerJoin('account', 'workspace_reservation_user_ID', 'account_ID')
            ->where('account_is_deleted', '=', 0)
            ->where('workspace_reservation_workspace_ID', '=', $this->workspaceID)
            ->where('workspace_reservation_is_deleted', '=', 0)
            ->where('workspace_reservation_accepted', '=', 1)
            ->whereBetween('workspace_reservation_start_datetime', $this->startDateTime, $this->endDateTime, true)
            ->whereOrBetween('workspace_reservation_end_datetime', $this->startDateTime, $this->endDateTime)
            ->execute()
            ->first();

        return $reservation;
    }

    /**
     * Check if the current reservation date is between a other reservation start en end date.
     *
     * @param int $workspaceID The id of the workspace.
     *
     * @return object
     */
    public function checkIfThereIsAOtherReservationBetweenTheCurrentDate(int $workspaceID = 0)
    {
        if (!empty($workspaceID)) {
            $this->workspaceID = $workspaceID;
        }

        // the start and end date to search reservations for
        $currentStartDate = new Chronos($this->startDateTime);
        $currentEndDate = new Chronos($this->endDateTime);

        // get the reservations
        $allReservationsByDate = $this->getAllByWorkspaceByDate(
            $workspaceID,
            $currentStartDate->toDateTimeString(),
            $currentEndDate->toDateTimeString()
        );

        if (!empty($allReservationsByDate)) {
            foreach ($allReservationsByDate as $reservation) {
                $startReservationDate = new Chronos($reservation->workspace_reservation_start_datetime ?? '');
                $endReservationDate = new Chronos($reservation->workspace_reservation_end_datetime ?? '');

                if ($currentStartDate->between($startReservationDate, $endReservationDate)
                    || $currentEndDate->between($startReservationDate, $endReservationDate)
                ) {
                    return $reservation;
                }
            }
        }

        return null;
    }

    /**
     * Get all the reservations.
     *
     * @return array
     */
    public function getAll()
    {
        $reservations = DB::table('workspace_reservation', 2)
            ->select(
                'workspace_reservation_ID',
                'workspace_reservation_user_ID',
                'workspace_reservation_workspace_ID',
                'workspace_reservation_start_datetime',
                'workspace_reservation_end_datetime',
                'workspace_reservation_accepted'
            )
            ->innerJoin('workspace', 'workspace_reservation_ID', 'workspace_ID')
            ->innerJoin('account', 'workspace_reservation_user_ID', 'account_ID')
            ->where('workspace_reservation_is_deleted', '=', 0)
            ->where('workspace_reservation_accepted', '=', 1)
            ->where('account_is_deleted', '=', 0)
            ->where('workspace_is_deleted', '=', 0)
            ->execute()
            ->toArray();

        return $reservations;
    }

    /**
     * Get all the reservations.
     *
     * @return array
     */
    public function getAllByUserAndWorkspace()
    {
        $slug = new Slug(0, 'werkplek');
        $date = new Chronos();

        $reservations = DB::table('workspace_reservation', 2)
            ->select(
                'workspace_reservation_ID',
                'workspace_reservation_user_ID',
                'workspace_reservation_workspace_ID',
                'workspace_name',
                'workspace_reservation_start_datetime',
                'workspace_reservation_end_datetime',
                'workspace_reservation_accepted'
            )
            ->innerJoin('workspace', 'workspace_reservation_workspace_ID', 'workspace_ID')
            ->innerJoin('account', 'workspace_reservation_user_ID', 'account_ID')
            ->where('workspace_reservation_is_deleted', '=', 0)
            ->where('workspace_reservation_accepted', '=', 1)
            ->where('account_ID', '=', $this->userID)
            ->where('account_is_deleted', '=', 0)
            ->where('workspace_slug_ID', '=', $slug->id)
            ->where('workspace_is_deleted', '=', 0)
            ->where('workspace_reservation_start_datetime', '>=', $date->toDateString())
            ->orderBy('ASC', 'workspace_reservation_start_datetime')
            ->execute()
            ->all();

        return $reservations;
    }

    /**
     * Get all the reservations by a workspace
     *
     * @param int    $workspaceID The id of the workspace.
     * @param string $startDate   The start date.
     * @param string $endDate     The end date.
     *
     * @return array
     */
    public function getAllByWorkspaceByDate(int $workspaceID, string $startDate, string $endDate)
    {
        $reservations = DB::table('workspace_reservation', 2)
            ->select(
                'workspace_reservation_ID',
                'workspace_reservation_user_ID',
                'account_name',
                'account_email',
                'account_education',
                'workspace_reservation_workspace_ID',
                'workspace_name',
                'workspace_reservation_start_datetime',
                'workspace_reservation_end_datetime',
                'workspace_reservation_accepted'
            )
            ->innerJoin('workspace', 'workspace_reservation_workspace_ID', 'workspace_ID')
            ->innerJoin('account', 'workspace_reservation_user_ID', 'account_ID')
            ->whereBetween('workspace_reservation_start_datetime', $startDate, $endDate, true)
            ->whereOrBetween('workspace_reservation_end_datetime', $startDate, $endDate)
            ->where('workspace_reservation_is_deleted', '=', 0)
            ->where('workspace_reservation_accepted', '=', 1)
            ->where('account_is_deleted', '=', 0)
            ->where('workspace_reservation_workspace_ID', '=', $workspaceID)
            ->where('workspace_is_deleted', '=', 0)
            ->orderBy('ASC', 'workspace_reservation_start_datetime')
            ->execute()
            ->all();

        return $reservations;
    }

    /**
     * Get all the reservations by a workspace
     *
     * @param int    $slugID    The slug id.
     * @param string $startDate The start date.
     * @param string $endDate   The end date.
     *
     * @return object
     */
    public function getAllByDate(int $slugID, string $startDate, string $endDate)
    {
        $reservations = DB::table('workspace_reservation', 2)
            ->select(
                'COUNT(workspace_reservation_ID) AS workspace_reservation_quantity'
            )
            ->innerJoin('workspace', 'workspace_reservation_workspace_ID', 'workspace_ID')
            ->innerJoin('account', 'workspace_reservation_user_ID', 'account_ID')
            ->whereBetween('workspace_reservation_start_datetime', $startDate, $endDate, true)
            ->whereOrBetween('workspace_reservation_end_datetime', $startDate, $endDate)
            ->where('workspace_reservation_is_deleted', '=', 0)
            ->where('workspace_reservation_accepted', '=', 1)
            ->where('account_is_deleted', '=', 0)
            ->where('workspace_slug_ID', '=', $slugID)
            ->where('workspace_is_deleted', '=', 0)
            ->execute()
            ->first();

        return $reservations;
    }

    /**
     * Get all the reservations by a workspace
     *
     * @param int    $slugID    The slug id.
     * @param string $startDate The start date.
     * @param string $endDate   The end date.
     *
     * @return array
     */
    public function getAllMeetingRoomReservationsByDate(int $slugID, string $startDate, string $endDate)
    {
        $reservations = DB::table('workspace_reservation', 2)
            ->select(
                'workspace_reservation_start_datetime',
                'workspace_reservation_end_datetime'
            )
            ->innerJoin('workspace', 'workspace_reservation_workspace_ID', 'workspace_ID')
            ->innerJoin('account', 'workspace_reservation_user_ID', 'account_ID')
            ->whereBetween('workspace_reservation_start_datetime', $startDate, $endDate, true)
            ->whereOrBetween('workspace_reservation_end_datetime', $startDate, $endDate)
            ->where('workspace_reservation_is_deleted', '=', 0)
            ->where('workspace_reservation_accepted', '=', 1)
            ->where('account_is_deleted', '=', 0)
            ->where('workspace_slug_ID', '=', $slugID)
            ->where('workspace_is_deleted', '=', 0)
            ->execute()
            ->all();

        return $reservations;
    }

    /**
     * Get all the reservations.
     *
     * @return array
     */
    public function getAllByUserAndMeetingRoom()
    {
        $slug = new Slug(0, 'vergaderruimte');
        $date = new Chronos();

        $reservations = DB::table('workspace_reservation', 2)
            ->select(
                'workspace_reservation_ID',
                'workspace_reservation_user_ID',
                'workspace_reservation_workspace_ID',
                'workspace_name',
                'workspace_reservation_start_datetime',
                'workspace_reservation_end_datetime',
                'workspace_reservation_accepted'
            )
            ->innerJoin('workspace', 'workspace_reservation_workspace_ID', 'workspace_ID')
            ->innerJoin('account', 'workspace_reservation_user_ID', 'account_ID')
            ->where('workspace_reservation_is_deleted', '=', 0)
            ->where('workspace_reservation_accepted', '=', 1)
            ->where('account_ID', '=', $this->userID)
            ->where('account_is_deleted', '=', 0)
            ->where('workspace_slug_ID', '=', $slug->id)
            ->where('workspace_is_deleted', '=', 0)
            ->where('workspace_reservation_start_datetime', '>=', $date->toDateTimeString())
            ->orderBy('ASC', 'workspace_reservation_start_datetime')
            ->execute()
            ->all();

        return $reservations;
    }

    /**
     * Soft delete an event by id as a student.
     *
     * @return bool
     */
    public function softDeleteAsUser()
    {
        $softDeleted = DB::table('workspace_reservation')
            ->delete()
            ->where('workspace_reservation_ID', '=', $this->id)
            ->where('workspace_reservation_user_ID', '=', $this->userID)
            ->execute()
            ->isSuccessful();

        if ($softDeleted && empty($this->get())) {
            Session::flash('success', Translation::get('reservation_successful_deleted'));
            return true;
        }

        Session::flash('error', Translation::get('reservation_unsuccessful_deleted'));
        return false;
    }

    /**
     * Soft delete an event by id.
     *
     * @return bool
     */
    public function softDelete()
    {
        $reservation = $this->get();
        $this->kind = intval($reservation->workspace_slug_ID) ?? 0;

        $softDeleted = DB::table('workspace_reservation')
            ->delete()
            ->where('workspace_reservation_ID', '=', $this->id)
            ->execute()
            ->isSuccessful();

        if ($softDeleted && empty($this->get())) {
            try {
                $settings = new Settings();
                $mail = new Mail();

                $workspaceName = $reservation->workspace_name ?? '';
                $date = parseToDate($reservation->workspace_reservation_start_datetime);

                if ($this->getKind() === 'werkplek') {
                    if (parseToTime($date) > '12:00:00') {
                        $time = 'in de middag';
                    } else {
                        $time = 'in de ochtend';
                    }

                } else {
                    $time = 'van ';
                    $time .= parseToTime($reservation->workspace_reservation_start_datetime);
                    $time .= ' tot en met ';
                    $time .= parseToTime($reservation->workspace_reservation_end_datetime);
                    $time .= ' uur';
                }

                $mail->setFrom($settings->get('companyEmail'),
                    $settings->get('companyName') . ' -  ' . ucfirst($this->getKind()) . ' reservering');
                $mail->addAddress($reservation->account_email ?? '', $reservation->account_name ?? '');
                $mail->setBody($settings->get('companyName'), 'deleteReservation', compact('workspaceName', 'date', 'time'));

                $mail->send();
            } catch (\Exception $exception) {
                CustomException::handle($exception);
            }

            Session::flash('success', Translation::get('reservation_successful_deleted'));
            return true;
        }

        Session::flash('error', Translation::get('reservation_unsuccessful_deleted'));
        return false;
    }

    /**
     * Get the kind of the reservation
     *
     * @param bool $converted Determine if the kind must be parsed
     *
     * @return string|int
     */
    public function getKind(bool $converted = true)
    {
        if ($converted) {
            if ($this->kind === $this->workspaceSlugID) {
                return 'werkplek';
            } elseif ($this->kind === $this->meetingRoomSlugID) {
                return 'vergaderruimte';
            }

            return '';
        }

        return $this->kind;
    }

    /**
     * Get the day part of the reservation
     *
     * @param bool $converted Determine if the day part must be parsed
     *
     * @return string
     */
    public function getDayPart(bool $converted = true)
    {
        if ($converted) {
            if ($this->dayPart === 'morning') {
                $dayPart = 'ochtend';
            } elseif ($this->dayPart === 'afternoon') {
                $dayPart = 'middag';
            }

            return $dayPart ?? '';
        }

        return $this->dayPart;
    }

    /**
     * Get the date of the reservation
     *
     * @param bool $converted Determine if the date must be parsed
     *
     * @return string
     */
    public function getDate(bool $converted = true)
    {
        if ($converted) {
            return parseToDate($this->date);
        }

        return parseToDateInput($this->date);
    }

    /**
     * Get the time.
     *
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set the duration of the reservation
     *
     * @return void
     */
    private function setDuration()
    {
        $meetingRoomDate = new Chronos($this->date . $this->time);
        $this->startDateTime = $meetingRoomDate->toDateTimeString();

        switch ($this->duration) {
        case self::HALF_HOUR_OPTION:
            $this->endDateTime = $meetingRoomDate->addMinutes(30)->toDateTimeString();
            break;
        case self::ONE_HOUR_OPTION:
            $this->endDateTime = $meetingRoomDate->addHour(1)->toDateTimeString();
            break;
        case self::ONE_AND_HALF_HOURS_OPTIONS:
            $date = $meetingRoomDate->addHour(1);
            $date = $date->addMinutes(30);

            $this->endDateTime = $date->toDateTimeString();
            break;
        case self::TWO_HOURS_OPTION:
            $this->endDateTime = $meetingRoomDate->addHour(2)->toDateTimeString();
            break;
        default:
            return;
                break;
        }
    }

    /**
     * Get the duration of the reservation
     *
     * @param bool $converted Determine if the duration must be parsed
     *
     * @return string|int
     */
    public function getDuration(bool $converted = true)
    {
        if ($converted) {
            switch ($this->duration) {
            case self::HALF_HOUR_OPTION:
                return 'voor een half uur';
                    break;
            case self::ONE_HOUR_OPTION:
                return 'voor een uur';
                    break;
            case self::ONE_AND_HALF_HOURS_OPTIONS:
                return 'voor een anderhalf uur';
                    break;
            case self::TWO_HOURS_OPTION:
                return 'voor 2 uur';
                    break;
            default:
                return '';
                    break;
            }
        }

        return $this->duration;
    }
}
