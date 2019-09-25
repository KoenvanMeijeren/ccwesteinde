<?php


namespace App\model\account;

use App\contracts\models\EditModel;
use App\model\admin\settings\Settings;
use App\services\core\Mail;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\exceptions\CustomException;
use App\services\session\Session;

class MakeStudent extends Student implements EditModel
{
    /**
     * The parameters to be inserted.
     *
     * @var array
     */
    private $_parameters;

    /**
     * Insert the account.
     *
     * @return bool
     */
    public function execute()
    {
        if ($this->prepare()) {
            $inserted = DB::table('account')
                ->insert($this->_parameters)
                ->execute()
                ->isSuccessful();

            try {
                $settings = new Settings();
                $mail = new Mail();
                $mail->setFrom($settings->get('companyEmail'), $settings->get('companyName') . ' -  Activeer je account');
                $mail->addAddress($this->email, $this->name);
                $token = $this->verificationToken;
                $email = $this->email;

                $mail->setBody($settings->get('companyName'), 'activationMail', compact('token', 'email'));
                $mail->send();
            } catch (\Exception $exception) {
                CustomException::handle($exception);
            }

            Session::flash('success', Translation::get('create_student_account_successful_message'));
            return $inserted;
        }

        return false;
    }

    /**
     * Prepare the account to be inserted.
     *
     * @return bool
     */
    private function prepare()
    {
        if ($this->validateInput()) {
            $encryptedPassword = password_hash($this->password, PASSWORD_BCRYPT);
            $this->_parameters['account_name'] = $this->name;
            $this->_parameters['account_education'] = $this->education;
            $this->_parameters['account_email'] = $this->email;
            $this->_parameters['account_password'] = $encryptedPassword;
            $this->_parameters['account_rights'] = 1;
            $this->_parameters['account_is_activated'] = 0;
            $this->_parameters['account_verification_token'] = $this->verificationToken;

            return true;
        }

        return false;
    }

    /**
     * Validate the input
     */
    private function validateInput()
    {
        if (empty($this->password)
            || empty($this->education)
            || empty($this->confirmationPassword)
            || empty($this->name)
            || empty($this->email)
        ) {
            Session::flash('error', Translation::get('form_message_for_required_fields'));
            return false;
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            Session::flash('error', Translation::get('form_invalid_email_message'));
            return false;
        }

        if ($this->password !== $this->confirmationPassword) {
            Session::flash('error', Translation::get('admin_passwords_are_not_the_same_message'));
            return false;
        }

        if (!empty($this->getByEmail())) {
            Session::flash('error', Translation::get('student_email_already_exists'));
            return false;
        }

        if (!is_string($this->name) || !is_string($this->education)) {
            Session::flash('error', Translation::get('form_invalid_data'));
            return false;
        }

        if (strlen($this->name) < 2 || strlen($this->name) > 50) {
            Session::flash('error', sprintf(Translation::get('form_invalid_string_length'), 'Naam', 2, 50));
            return false;
        }

        if (strlen($this->education) < 2 || strlen($this->education) > 50) {
            Session::flash('error', sprintf(Translation::get('form_invalid_string_length'), 'Opleiding', 2, 50));
            return false;
        }

        if (strlen($this->password) < 4) {
            Session::flash('error', sprintf(Translation::get('form_min_invalid_string_length'), 'Wachtwoord', 4));
            return false;
        }

        if (strlen($this->confirmationPassword) < 4) {
            Session::flash('error', sprintf(Translation::get('form_min_invalid_string_length'), 'Bevestigingswachtwoord', 4));
            return false;
        }

        return true;
    }
}
