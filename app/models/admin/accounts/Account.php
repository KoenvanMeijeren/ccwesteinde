<?php


namespace App\model\admin\accounts;

use App\contracts\models\accounts\AccountModelInterface;
use App\model\admin\account\User;
use App\services\core\Request;
use App\services\core\Router;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\session\Session;

class Account implements AccountModelInterface
{
    /**
     * Accessible for everyone rights.
     */
    const ACCOUNT_RIGHTS_LEVEL_0 = 0;

    /**
     * Student rights
     */
    const ACCOUNT_RIGHTS_LEVEL_1 = 1;

    /**
     * Teacher rights
     */
    const ACCOUNT_RIGHTS_LEVEL_2 = 2;

    /**
     * Admin rights.
     */
    const ACCOUNT_RIGHTS_LEVEL_3 = 3;

    /**
     * Super admin rights.
     */
    const ACCOUNT_RIGHTS_LEVEL_4 = 4;

    /**
     * The id of the account.
     *
     * @var int
     */
    protected $id;

    /**
     * The name of the account.
     *
     * @var string
     */
    protected $name;

    /**
     * The education of the account.
     *
     * @var string
     */
    protected $education;

    /**
     * The email of the account.
     *
     * @var string
     */
    protected $email;

    /**
     * The password of the account.
     *
     * @var string
     */
    protected $password;

    /**
     * The confirmation password of the account.
     *
     * @var string
     */
    protected $confirmationPassword;

    /**
     * The rights of the account.
     *
     * @var int
     */
    protected $rights;

    /**
     * Construct the account.
     */
    public function __construct()
    {
        $request = new Request();
        
        $this->id = intval(Router::getWildcard());
        $this->name = $request->post('name');
        $this->email = $request->post('email');
        $this->password = $request->post('password');
        $this->confirmationPassword = $request->post('confirmationPassword');
        $this->rights = intval($request->post('rights'));

        // if account is a student, request the education
        if ($this->rights === 1) {
            $this->education = $request->post('education');
        }
    }

    /**
     * Get a specific account.
     *
     * @return object|null
     */
    public function get()
    {
        $account = DB::table('account')
            ->select('*')
            ->where('account_ID', '=', $this->id)
            ->where('account_is_deleted', '=', 0)
            ->where('account_is_activated', '=', 1)
            ->execute()
            ->first();

        return $account;
    }

    /**
     * Get a specific account by email.
     *
     * @return object|null
     */
    public function getByEmail()
    {
        $account = DB::table('account')
            ->select('*')
            ->where('account_email', '=', $this->email)
            ->where('account_is_deleted', '=', 0)
            ->where('account_is_activated', '=', 1)
            ->execute()
            ->first();

        return $account;
    }

    /**
     * Get all accounts.
     *
     * @return array with accounts.
     */
    public function getAll()
    {
        $accounts = DB::table('account')
            ->select('account_ID', 'account_name', 'account_email', 'account_rights', 'account_is_blocked')
            ->where('account_is_deleted', '=', 0)
            ->where('account_is_activated', '=', 1)
            ->orderBy('DESC', 'account_ID')
            ->execute()
            ->toArray();

        return $accounts;
    }

    /**
     * Unblock a specific account.
     *
     * @return bool
     */
    public function unblock()
    {
        $unblocked = DB::table('account')
            ->update(['account_is_blocked' => 0])
            ->where('account_ID', '=', $this->id)
            ->where('account_is_deleted', '=', 0)
            ->where('account_is_activated', '=', 1)
            ->execute()
            ->isSuccessful();

        Session::flash('success', Translation::get('admin_account_successful_unblocked_message'));
        return $unblocked;
    }

    /**
     * Soft delete a specific account
     *
     * @return void
     */
    public function softDelete()
    {
        $user = new User();
        if ($user->getID() === $this->id) {
            Session::flash('error', Translation::get('cannot_delete_own_account_message'));
            return;
        }

        $isSoftDeleted = DB::table('account')
            ->softDelete('account_is_deleted', 1)
            ->where('account_ID', '=', $this->id)
            ->execute()
            ->isSuccessful();

        if ($isSoftDeleted && empty($this->get())) {
            Session::flash('success', Translation::get('admin_deleted_account_successful_message'));
            return;
        }

        Session::flash('error', Translation::get('admin_deleted_account_failed_message'));
        return;
    }

    /**
     * Get the id of the user.
     *
     * @return int
     */
    public function getID()
    {
        return $this->id;
    }
}
