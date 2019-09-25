<?php


namespace App\model\admin\accounts;

use App\contracts\models\accounts\MakeAccountModelInterface;
use App\contracts\models\EditModel;
use App\model\admin\settings\Settings;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\session\Session;

class MakeAccount extends Account implements EditModel
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

            Session::flash('success', Translation::get('admin_create_account_successful_message'));
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
            $this->_parameters['account_email'] = $this->email;
            $this->_parameters['account_password'] = $encryptedPassword;
            $this->_parameters['account_rights'] = $this->rights;
            $this->_parameters['account_is_activated'] = 1;

            return true;
        }

        return false;
    }

    /**
     * Validate the given input.
     *
     * @return bool
     */
    private function validateInput()
    {
        if (empty($this->name)) {
            Session::flash('error', Translation::get('form_empty_name_message'));
            return false;
        }

        if (empty($this->email)) {
            Session::flash('error', Translation::get('form_empty_email_message'));
            return false;
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            Session::flash('error', Translation::get('form_invalid_email_message'));
            return false;
        }

        $rights = intval($this->rights);
        if ($rights === Account::ACCOUNT_RIGHTS_LEVEL_1 || $rights === Account::ACCOUNT_RIGHTS_LEVEL_2) {
            $email = $this->email;
            $emailExploded = explode('@', $email);
            $lastKey = array_key_last($emailExploded);
            $secondPartOfEmail = $emailExploded[$lastKey];

            $settings = new Settings();
            if ($rights === Account::ACCOUNT_RIGHTS_LEVEL_1 && $secondPartOfEmail !== $settings->get('studentEmail')) {
                Session::flash('error', Translation::get('invalid_student_email_message'));
                return false;
            }

            if ($rights === Account::ACCOUNT_RIGHTS_LEVEL_2 && $secondPartOfEmail !== $settings->get('teacherEmail')) {
                Session::flash('error', Translation::get('invalid_teacher_email_message'));
                return false;
            }
        }

        if (!$this->_validateRights($this->rights)) {
            return false;
        }

        if (empty($this->password) || empty($this->confirmationPassword)) {
            return false;
        }

        if ($this->password !== $this->confirmationPassword) {
            Session::flash('error', Translation::get('admin_passwords_are_not_the_same_message'));
            return false;
        }

        if (!empty($this->getByEmail())) {
            Session::flash(
                'error',
                sprintf(Translation::get('admin_email_already_exists_message'), $this->email)
            );
            return false;
        }

        return true;
    }

    /**
     * Validate the given rights.
     *
     * @param mixed $rights The rights to validate.
     *
     * @return bool
     */
    private function _validateRights($rights)
    {
        if ($rights === Account::ACCOUNT_RIGHTS_LEVEL_1
            || $rights === Account::ACCOUNT_RIGHTS_LEVEL_2
            || $rights === Account::ACCOUNT_RIGHTS_LEVEL_3
            || $rights === Account::ACCOUNT_RIGHTS_LEVEL_4
        ) {
            return true;
        }

        Session::flash('error', Translation::get('admin_invalid_rights_message'));
        return false;
    }
}
