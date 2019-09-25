<?php


namespace App\model\admin\accounts;

use App\contracts\models\accounts\UpdateAccountModelInterface;
use App\contracts\models\EditModel;
use App\model\admin\settings\Settings;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\session\Session;

class UpdateAccount extends Account implements EditModel
{
    /**
     * The parameters to be inserted.
     *
     * @var array
     */
    private $_parameters;

    /**
     * Update the account.
     *
     * @return bool
     */
    public function execute()
    {
        if ($this->prepare()) {
            $updated = DB::table('account')
                ->update($this->_parameters)
                ->where('account_ID', '=', $this->id)
                ->execute()
                ->isSuccessful();

            Session::flash('success', Translation::get('admin_edited_account_successful_message'));
            return $updated;
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
        $prepared = false;
        if ($this->validateInput()) {
            $this->_parameters['account_name'] = $this->name;
            $this->_parameters['account_email'] = $this->email;
            $this->_parameters['account_rights'] = $this->rights;

            if (!empty($this->education)) {
                $this->_parameters['account_education'] = $this->education;
            }

            $prepared = true;
        }

        if ($this->validatePasswords()) {
            $encryptedPassword = password_hash($this->password, PASSWORD_BCRYPT);
            $this->_parameters['account_password'] = $encryptedPassword;

            $prepared = true;
        }

        return $prepared;
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

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            Session::flash('error', Translation::get('form_invalid_email_message'));
            return false;
        }

        if (!$this->_validateRights($this->rights)) {
            return false;
        }

        return true;
    }

    /**
     * Validate the passwords.
     *
     * @return bool
     */
    private function validatePasswords()
    {
        if (empty($this->password) || empty($this->confirmationPassword)) {
            return false;
        }

        if ($this->password !== $this->confirmationPassword) {
            Session::flash('error', Translation::get('admin_passwords_are_not_the_same_message'));
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
