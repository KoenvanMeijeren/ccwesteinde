<?php


namespace App\model\signUp;

use App\contracts\models\signUp\SignUpModel;
use App\model\admin\account\User;
use App\model\admin\settings\Settings;
use App\model\event\Event;
use App\services\core\Mail;
use App\services\core\Router;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\exceptions\CustomException;
use App\services\session\Session;
use Cake\Chronos\Chronos;

class SignUp implements SignUpModel
{
    /**
     * The id of the sign up.
     *
     * @var int
     */
    protected $id = 0;

    /**
     * The user of the sign up.
     *
     * @var User
     */
    protected $user;

    /**
     * The event of the sign up.
     *
     * @var Event
     */
    protected $event;

    /**
     * Construct the sign up.
     */
    public function __construct()
    {
        $this->id = intval(Router::getWildcard());
        $this->user = new User();
        $this->event = new Event();
    }

    /**
     * Get a sign up.
     *
     * @return object
     */
    public function get()
    {
        $signUp = DB::table('signup', 2)
            ->select(
                'signUp_ID',
                'signUp_user_ID',
                'account_name AS signUp_user_name',
                'account_email AS signUp_user_email',
                'signUp_event_ID',
                'event_title AS signUp_event_title',
                'event_location AS signUp_event_location',
                'event_start_datetime AS signUp_event_start_datetime',
                'event_end_datetime AS signUp_event_end_datetime',
                'signUp_accepted'
            )
            ->innerJoin('account', 'signUp_user_ID', 'account_ID')
            ->innerJoin('event', 'signUp_event_ID', 'event_ID')
            ->where('account_is_deleted', '=', 0)
            ->where('account_rights', '=', 1)
            ->where('event_is_deleted', '=', 0)
            ->where('event_is_archived', '=', 0)
            ->where('signUp_ID', '=', $this->id)
            ->where('signUp_is_deleted', '=', 0)
            ->execute()
            ->first();

        return $signUp;
    }

    /**
     * Get all sign ups by user.
     *
     * @return array
     */
    public function getAllByUser()
    {
        $date = new Chronos();
        $signUps = DB::table('signup', 2)
            ->select(
                'signUp_ID',
                'signUp_user_ID',
                'account_name AS signUp_user_name',
                'account_email AS signUp_user_email',
                'signUp_event_ID',
                'event_title AS signUp_event_title',
                'event_location AS signUp_event_location',
                'event_start_datetime AS signUp_event_start_datetime',
                'event_end_datetime AS signUp_event_end_datetime',
                'signUp_accepted'
            )
            ->innerJoin('account', 'signUp_user_ID', 'account_ID')
            ->innerJoin('event', 'signUp_event_ID', 'event_ID')
            ->where('account_is_deleted', '=', 0)
            ->where('account_rights', '=', 1)
            ->where('event_is_deleted', '=', 0)
            ->where('event_is_archived', '=', 0)
            ->where('account_ID', '=', $this->user->getID())
            ->where('signUp_is_deleted', '=', 0)
            ->where('event_start_datetime', '>=', $date->toDateTimeString())
            ->orderBy('ASC', 'event_start_datetime')
            ->execute()
            ->all();

        return $signUps;
    }

    /**
     * Get all sign ups per event.
     *
     * @param int $limit The maximum number of records to be returned.
     *
     * @return array
     */
    public function getAllEvents(int $limit)
    {
        $date = new Chronos();

        $signUps = DB::table('signup', 1)
            ->selectDistinct(
                'signUp_event_ID',
                'event_title AS signUp_event_title',
                'event_location AS signUp_event_location',
                'event_start_datetime AS signUp_event_start_datetime',
                'event_end_datetime AS signUp_event_end_datetime',
                'event_maximum_persons AS signUp_event_maximum_persons'
            )
            ->innerJoin('event', 'signUp_event_ID', 'event_ID')
            ->where('event_is_deleted', '=', 0)
            ->where('event_is_archived', '=', 0)
            ->where('signUp_is_deleted', '=', 0)
            ->where('event_start_datetime', '>=', $date->toDateTimeString())
            ->orderBy('ASC', 'event_start_datetime')
            ->limit($limit)
            ->execute()
            ->all();

        return $signUps;
    }

    /**
     * Get all sign ups per event.
     *
     * @param int $limit The maximum number of records to be returned.
     *
     * @return array
     */
    public function getAllEventsHistory(int $limit)
    {
        $date = new Chronos();

        $signUps = DB::table('signup', 1)
            ->selectDistinct(
                'signUp_event_ID',
                'event_title AS signUp_event_title',
                'event_location AS signUp_event_location',
                'event_start_datetime AS signUp_event_start_datetime',
                'event_end_datetime AS signUp_event_end_datetime',
                'event_maximum_persons AS signUp_event_maximum_persons'
            )
            ->innerJoin('event', 'signUp_event_ID', 'event_ID')
            ->where('event_is_deleted', '=', 0)
            ->where('event_is_archived', '=', 0)
            ->where('signUp_is_deleted', '=', 0)
            ->where('event_start_datetime', '<', $date->toDateTimeString())
            ->orderBy('ASC', 'event_start_datetime')
            ->limit($limit)
            ->execute()
            ->all();

        return $signUps;
    }

    /**
     * Get all sign ups per event.
     *
     * @param int $eventID The id of the event to get the sign ups for.
     *
     * @return array
     */
    public function getAllPerEvent(int $eventID)
    {
        $signUps = DB::table('signup', 2)
            ->select(
                'signUp_ID',
                'account_name AS signUp_user_name',
                'account_education AS signUp_user_education',
                'account_email AS signUp_user_email'
            )
            ->innerJoin('event', 'signUp_event_ID', 'event_ID')
            ->innerJoin('account', 'signUp_user_ID', 'account_ID')
            ->where('account_rights', '=', 1)
            ->where('account_is_deleted', '=', 0)
            ->where('event_ID', '=', $eventID)
            ->where('event_is_deleted', '=', 0)
            ->where('event_is_archived', '=', 0)
            ->where('signUp_is_deleted', '=', 0)
            ->execute()
            ->all();

        return $signUps;
    }

    /**
     * Get all sign ups by user.
     *
     * @return array
     */
    public function getAllEventByUser()
    {
        $signUps = DB::table('signup', 2)
            ->select(
                'signUp_ID',
                'signUp_user_ID',
                'account_name AS signUp_user_name',
                'account_email AS signUp_user_email',
                'signUp_event_ID',
                'event_title AS signUp_event_title',
                'event_location AS signUp_event_location',
                'event_start_datetime AS signUp_event_start_datetime',
                'event_end_datetime AS signUp_event_end_datetime',
                'signUp_accepted'
            )
            ->innerJoin('account', 'signUp_user_ID', 'account_ID')
            ->innerJoin('event', 'signUp_event_ID', 'event_ID')
            ->where('account_is_deleted', '=', 0)
            ->where('account_rights', '=', 1)
            ->where('event_is_deleted', '=', 0)
            ->where('event_is_archived', '=', 0)
            ->where('event_ID', '=', $this->event->get()->event_ID ?? 0)
            ->where('account_ID', '=', $this->user->getID())
            ->where('signUp_is_deleted', '=', 0)
            ->execute()
            ->all();

        return $signUps;
    }

    /**
     * Soft delete an event by id as student.
     *
     * @return bool
     */
    public function softDeleteAsUser()
    {
        $event = $this->get();
        $date = new Chronos($event->signUp_event_start_datetime ?? '');
        $isInNext2days = $date->isWithinNext('2 days');

        if (!$isInNext2days) {
            $softDeleted = DB::table('signup')
                ->delete()
                ->where('signUp_ID', '=', $this->id)
                ->where('signUp_user_ID', '=', $this->user->getID())
                ->execute()
                ->isSuccessful();

            if ($softDeleted && empty($this->get())) {
                Session::flash('success', Translation::get('sign_up_successful_deleted'));
                return true;
            }
        }

        Session::flash('error', Translation::get('sign_up_unsuccessful_deleted'));
        return false;
    }

    /**
     * Soft delete an event by id.
     *
     * @return bool
     */
    public function softDelete()
    {
        $signUp = $this->get();

        $softDeleted = DB::table('signup')
            ->delete()
            ->where('signUp_ID', '=', $this->id)
            ->execute()
            ->isSuccessful();

        if ($softDeleted && empty($this->get())) {
            try {
                $settings = new Settings();
                $mail = new Mail();

                $title = $signUp->signUp_event_title ?? '';
                $location = $signUp->signUp_event_location ?? '';
                $date = parseToDate($signUp->signUp_event_start_datetime ?? '');
                $time = 'van ';
                $time .= parseToTime($signUp->signUp_event_start_datetime ?? '');
                $time .= ' tot en met ';
                $time .= parseToTime($signUp->signUp_event_end_datetime ?? '');
                $time .= ' uur';

                $mail->setFrom($settings->get('companyEmail'),
                    $settings->get('companyName') . ' -  Aanmelding voor Meet the Expert ' . $signUp->signUp_event_title ?? '');
                $mail->addAddress($signUp->signUp_user_email ?? '', $signUp->signUp_user_name ?? '');
                $mail->setBody($settings->get('companyName'), 'deleteSignUp',
                    compact('title','location', 'date', 'time'));

                $mail->send();
            } catch (\Exception $exception) {
                CustomException::handle($exception);
            }

            Session::flash('success', Translation::get('sign_up_successful_deleted'));
            return true;
        }

        Session::flash('error', Translation::get('sign_up_unsuccessful_deleted'));
        return false;
    }
}
