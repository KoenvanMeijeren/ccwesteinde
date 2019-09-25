<?php


namespace App\model\reservation;

use App\contracts\models\EditModel;
use App\model\admin\account\User;
use App\model\admin\accounts\Account;
use App\model\admin\settings\Settings;
use App\model\admin\workspace\Workspace;
use App\services\core\Mail;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\exceptions\CustomException;
use App\services\session\Session;
use Cake\Chronos\Chronos;

class MakeReservation extends Reservation implements EditModel
{
    /**
     * The parameters
     *
     * @var array
     */
    private $parameters;

    /**
     * Execute the making of the reservation.
     *
     * @return bool
     */
    public function execute()
    {
        if ($this->prepare()) {
            $inserted = DB::table('workspace_reservation')
                ->insert($this->parameters)
                ->execute()
                ->isSuccessful();

            if ($inserted) {
                try {
                    $settings = new Settings();
                    $user = new User();
                    $mail = new Mail();
                    $workspace = new Workspace();

                    $workspace->setID($this->workspaceID);
                    $workspace = $workspace->get();
                    $workspaceName = $workspace->workspace_name ?? '';

                    $date = parseToDate($this->startDateTime);
                    if ($this->getKind() === 'werkplek') {
                        $time = 'in de ' . $this->getDayPart();
                    } else {
                        $time = 'van ';
                        $time .= parseToTime($this->startDateTime);
                        $time .= ' tot en met ';
                        $time .= parseToTime($this->endDateTime);
                        $time .= ' uur';
                    }

                    $mail->setFrom($settings->get('companyEmail'), $settings->get('companyName') . ' -  Werkplek reservering');
                    $mail->addAddress($user->account->account_email ?? '', $user->account->account_name ?? '');
                    $mail->setBody($settings->get('companyName'), 'makeReservation', compact('workspaceName', 'date', 'time'));

                    $mail->send();
                } catch (\Exception $exception) {
                    CustomException::handle($exception);
                }

                return true;
            }

            Session::flash('error', Translation::get('reservation_unsuccessfully_created'));
        }

        return false;
    }

    /**
     * Prepare the making of the reservation.
     *
     * @return bool
     */
    private function prepare()
    {
        if ($this->validate()) {
            $this->parameters['workspace_reservation_user_ID'] = $this->userID;
            $this->parameters['workspace_reservation_workspace_ID'] = $this->workspaceID;
            $this->parameters['workspace_reservation_start_datetime'] = $this->startDateTime;
            $this->parameters['workspace_reservation_end_datetime'] = $this->endDateTime;
            $this->parameters['workspace_reservation_accepted'] = 1;

            return true;
        }

        return false;
    }

    /**
     * Validate the input
     *
     * @return bool
     */
    private function validate()
    {
        // input cannot be empty
        if (empty($this->workspaceID) || empty($this->startDateTime) || empty($this->endDateTime)) {
            Session::flash('error', Translation::get('something_went_wrong'));
            return false;
        }

        // check if the rights are good
        $user = new User();
        if ($this->getKind() === 'werkplek' && $user->getRights() !== Account::ACCOUNT_RIGHTS_LEVEL_1) {
            $translation = Translation::get('invalid_user_reservation');
            if ($this->getKind() === 'vergaderruimte') {
                $translation = str_replace('werkplek', 'vergaderruimte', $translation);
            }

            Session::flash('error', $translation);
            return false;
        }

        // check if the workspace already is reserved
        // search for an exactly match
        // check if there is an other reservation between the start or end datetime.
        if (!empty($this->getByWorkspaceAndDateTime())
            || !empty($this->getByWorkspaceInBetweenStartOrEndDateTime())
            || !empty($this->checkIfThereIsAOtherReservationBetweenTheCurrentDate())
        ) {
            $translation = Translation::get('workspace_already_reserved');
            if ($this->getKind() === 'vergaderruimte') {
                $translation = str_replace('werkplek', 'vergaderruimte', $translation);
            }

            Session::flash('error', $translation);
            return false;
        }

        $startDate = new Chronos($this->startDateTime);
        if ($startDate->isWeekend()) {
            $translation = Translation::get('cannot_reserve_workspace_in_weekend');
            if ($this->getKind() === 'vergaderruimte') {
                $translation = str_replace('werkplek', 'vergaderruimte', $translation);
            }

            Session::flash('error', $translation);
            return false;
        }

        if ($startDate->isPast() && $this->getKind() === 'vergaderruimte') {
            $translation = Translation::get('workspace_cannot_reserved_earlier_than_now');
            if ($this->getKind() === 'vergaderruimte') {
                $translation = str_replace('werkplek', 'vergaderruimte', $translation);
            }

            Session::flash('error', $translation);
            return false;
        }

        $currentDate = new Chronos();
        $startDate = new Chronos($this->startDateTime);
        if ($startDate->toTimeString() < '12:00:00'
            && $currentDate->toTimeString() > '12:00:00'
            && $this->getDayPart() === 'ochtend'
            && $startDate->isToday()
        ) {
            $translation = Translation::get('workspace_cannot_reserved_earlier_than_now');
            if ($this->getKind() === 'vergaderruimte') {
                $translation = str_replace('werkplek', 'vergaderruimte', $translation);
            }

            Session::flash('error', $translation);
            return false;
        }

        $settings = new Settings();
        $openingHour = new Chronos($settings->get('schoolOpeningHour'));
        $startDateTime = new Chronos($this->startDateTime);
        if ($this->getKind() === 'vergaderruimte' && $startDateTime->toTimeString() < $openingHour->toTimeString()) {
            Session::flash(
                'error', sprintf(
                    Translation::get('cannot_reserve_before_opening_hour'),
                    parseToTime($openingHour->toTimeString())
                )
            );
            return false;
        }

        $closingHour = new Chronos($settings->get('schoolClosingHour'));
        $endDateTime = new Chronos($this->endDateTime);
        if ($this->getKind() === 'vergaderruimte' && $endDateTime->toTimeString() > $closingHour->toTimeString()) {
            Session::flash(
                'error', sprintf(
                    Translation::get('cannot_reserve_after_closing_hour'),
                    parseToTime($closingHour->toTimeString())
                )
            );
            return false;
        }

        return true;
    }
}
