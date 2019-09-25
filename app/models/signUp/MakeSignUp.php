<?php


namespace App\model\signUp;

use App\contracts\models\EditModel;
use App\model\admin\account\User;
use App\model\admin\settings\Settings;
use App\services\core\Mail;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\exceptions\CustomException;
use App\services\session\Session;
use Cake\Chronos\Chronos;

class MakeSignUp extends SignUp implements EditModel
{
    /**
     * The parameters
     *
     * @var array
     */
    private $parameters;

    /**
     * Execute the making of the event.
     *
     * @return bool
     */
    public function execute()
    {
        if ($this->prepare()) {
            $lastInsertedId = DB::table('signup')
                ->insert($this->parameters)
                ->execute()
                ->getLastInsertedId();
            $this->id = $lastInsertedId;

            if (!empty($this->get())) {
                try {
                    $settings = new Settings();
                    $user = new User();
                    $mail = new Mail();
                    $signUp = $this->get();
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
                    $mail->addAddress($user->account->account_email ?? '', $user->account->account_name ?? '');
                    $mail->setBody($settings->get('companyName'), 'makeSignUp', compact('title','location', 'date', 'time'));

                    $mail->send();
                } catch (\Exception $exception) {
                    CustomException::handle($exception);
                }

                Session::flash('success', Translation::get('sign_up_successfully_created'));
                return true;
            }

            Session::flash('error', Translation::get('sign_up_unsuccessfully_created'));
        }

        return false;
    }

    /**
     * Prepare the making of the event.
     *
     * @return bool
     */
    private function prepare()
    {
        if ($this->validate()) {
            $this->parameters['signUp_user_ID'] = $this->user->getID();
            $this->parameters['signUp_event_ID'] = $this->event->get()->event_ID ?? 0;
            $this->parameters['signUp_accepted'] = 1;

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
        if (empty($this->user->getID())
            || empty($this->event->get()->event_ID ?? 0)
        ) {
            return false;
        }

        if ($this->user->getRights() !== 1) {
            Session::flash('error', Translation::get('invalid_user_sign_up'));
            return false;
        }

        $event = $this->event->get();
        if (intval($event->event_maximum_persons ?? 0) - intval($event->event_sign_ups ?? 0) <= 0) {
            Session::flash('error', Translation::get('event_is_full'));
            return false;
        }

        if (is_array($this->getAllEventByUser()) && count($this->getAllEventByUser()) >= 1) {
            Session::flash('error', Translation::get('maximum_of_one_sign_up_per_user'));
            return false;
        }

        $date = new Chronos();
        if (strtotime($event->event_start_datetime ?? '') < strtotime($date->toDateTimeString())) {
            Session::flash('error', Translation::get('cannot_sign_up_for_an_event_which_already_is_started'));
            return false;
        }

        return true;
    }
}
