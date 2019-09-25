<?php


namespace App\model\admin\account;

use App\contracts\models\account\UpdateUserModelInterface;
use App\model\admin\accounts\Account;
use App\services\core\Request;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\session\Session;

class UpdateUser implements UpdateUserModelInterface
{
    /**
     * The account of the user.
     *
     * @var object
     */
    private $_account;

    /**
     * The id of the user.
     *
     * @var int
     */
    private $_id;

    /**
     * The name of the user.
     *
     * @var string
     */
    private $_name;

    /**
     * The current password of the user.
     *
     * @var string
     */
    private $_currentPassword;

    /**
     * The new password of the user.
     *
     * @var string
     */
    private $_password;

    /**
     * The confirmation password of the user.
     *
     * @var string
     */
    private $_confirmationPassword;

    /**
     * The array with the columns and values to be updated.
     *
     * @var array
     */
    private $_update;

    /**
     * Is the user updated?
     *
     * @var bool
     */
    private $isUpdated;

    /**
     * Construct the user to be updated.
     *
     * @param int    $id      The id of the user.
     * @param object $account The account of the user.
     */
    public function __construct(int $id, $account)
    {
        $request = new Request();

        $this->_account = $account;
        $this->_id = $id;
        $this->_name = $request->post('name');
        $this->_currentPassword = $request->post('currentPassword');
        $this->_password = $request->post('password');
        $this->_confirmationPassword = $request->post('confirmPassword');
    }

    /**
     * Prepare the user to be updated.
     *
     * @return bool
     */
    public function execute()
    {
        if (intval($this->_account->account_rights) >= Account::ACCOUNT_RIGHTS_LEVEL_3 && $this->validateName()) {
            $this->_update['account_name'] = $this->_name;
            $this->update();
        }

        if ($this->_validatePasswords()) {
            $encryptedPassword = password_hash($this->_password, PASSWORD_BCRYPT);
            $this->_update['account_password'] = $encryptedPassword;
            $this->update();
        }

        if (!isset($_SESSION['error'])) {
            Session::flash('success', Translation::get('admin_edited_account_successful_message'));
            return true;
        }

        if ($this->validateName() && intval($this->_account->account_rights) >= Account::ACCOUNT_RIGHTS_LEVEL_3) {
            Session::flash('success', Translation::get('admin_edited_account_successful_message'));
            return true;
        }

        return false;
    }

    /**
     * Update the user.
     *
     * @return void
     */
    private function update()
    {
        $updated = DB::table('account')
            ->update($this->_update)
            ->where('account_ID', '=', $this->_id)
            ->where('account_is_deleted', '=', 0)
            ->execute()
            ->isSuccessful();

        $this->isUpdated = $updated;
    }

    /**
     * Validate the passwords.
     *
     * @return bool
     */
    private function _validatePasswords()
    {
        if (empty($this->_password) || empty($this->_currentPassword) || empty($this->_confirmationPassword)) {
            return false;
        }

        if ($this->_password !== $this->_confirmationPassword) {
            Session::flash('error', Translation::get('admin_passwords_are_not_the_same_message'));
            return false;
        }

        if (!password_verify($this->_currentPassword, $this->_account->account_password ?? '')) {
            Session::flash('error', Translation::get('admin_edit_account_wrong_current_password_message'));
            return false;
        }

        return true;
    }

    /**
     * Validate the input
     *
     * @return bool
     */
    private function validateName()
    {
        if (empty($this->_name)) {
            Session::flash('error', Translation::get('form_message_for_required_fields'));
            return false;
        }

        return true;
    }
}
