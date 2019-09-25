<?php


namespace App\controllers\admin;

use App\contracts\controllers\AccountsControllerInterface;
use App\model\admin\accounts\Account;
use App\model\admin\accounts\MakeAccount;
use App\model\admin\accounts\UpdateAccount;
use App\services\core\Translation;
use App\services\core\View;
use App\services\response\RedirectResponse;
use App\services\session\Session;

class AccountsController implements AccountsControllerInterface
{
    /**
     * The account.
     *
     * @var Account
     */
    private $_account;

    /**
     * Construct the account.
     */
    public function __construct()
    {
        $this->_account = new Account();
    }

    /**
     * Overview of all the accounts.
     *
     * @return View
     */
    public function index()
    {
        $title = Translation::get('admin_accounts_maintenance_title');
        $accounts = $this->_account->getAll();

        return new View('admin/account/accounts', compact('title', 'accounts'));
    }

    /**
     * Show the form to create a new account.
     *
     * @return View
     */
    public function create()
    {
        $title = Translation::get('admin_create_account_title');

        return new View('admin/account/create', compact('title'));
    }

    /**
     * Proceed the user call from the method create and store it.
     *
     * @return RedirectResponse|View
     */
    public function store()
    {
        $makeAccount = new MakeAccount();
        if ($makeAccount->execute()) {
            return new RedirectResponse('/admin/accounts');
        }

        return $this->create();
    }

    /**
     * Show the form to edit a specific account.
     *
     * @return View|RedirectResponse
     */
    public function edit()
    {
        $title = Translation::get('admin_edit_account_title');
        $account = $this->_account->get();

        if (!empty($account)) {
            return new View('admin/account/edit', compact('title', 'account'));
        }

        Session::flash('error', Translation::get('unknown_account_visited'));
        return new RedirectResponse('/admin/accounts');
    }

    /**
     * Update a specific account.
     *
     * @return RedirectResponse|View
     */
    public function update()
    {
        $updateAccount = new UpdateAccount();
        if ($updateAccount->execute()) {
            return new RedirectResponse('/admin/accounts');
        }

        return $this->edit();
    }

    /**
     * Unblock a specific account.
     *
     * @return RedirectResponse
     */
    public function unblock()
    {
        $this->_account->unblock();

        return new RedirectResponse('/admin/accounts');
    }

    /**
     * Soft delete a specific account.
     *
     * @return RedirectResponse
     */
    public function destroy()
    {
        if ($this->_account->getID() === Session::get('id')) {
            Session::flash('error', 'Je kan niet je eigen account verwijderen.');
            return new RedirectResponse('/admin/accounts');
        }

        $this->_account->softDelete();

        return new RedirectResponse('/admin/accounts');
    }
}
