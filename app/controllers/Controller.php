<?php


namespace App\controllers;

use App\contracts\controllers\LoginControllerInterface;
use App\model\account\MakeStudent;
use App\model\admin\account\Login;
use App\model\admin\account\UpdateUser;
use App\model\admin\account\User;
use App\services\core\Translation;
use App\services\core\View;
use App\services\response\RedirectResponse;
use App\services\security\CSRF;
use App\services\session\Session;

class Controller implements LoginControllerInterface
{
    /**
     * The user.
     *
     * @var User
     */
    private $_user;

    /**
     * Construct the user.
     */
    public function __construct()
    {
        $this->_user = new User();
    }

    /**
     * Overview of the login page.
     *
     * @return View|RedirectResponse
     */
    public function index()
    {
        $title = Translation::get('login_page_title');
        if (!empty($this->_user->getRights())) {
            return new RedirectResponse('/account/bewerken');
        }

        return new View('account/index', compact('title'));
    }

    /**
     * Overview of the register page.
     *
     * @return View
     */
    public function create()
    {
        $title = Translation::get('register_page_title');

        return new View('account/register', compact('title'));
    }

    /**
     * Proceed the user call from the method index and try to store the user.
     *
     * @return RedirectResponse|View
     */
    public function store()
    {
        $makeStudent = new MakeStudent();
        if (CSRF::validate() && $makeStudent->execute()) {
            return new RedirectResponse('/inloggen');
        }

        return $this->create();
    }

    /**
     * Activate the user.
     *
     * @return RedirectResponse|View
     */
    public function activate()
    {
        if ($this->_user->activate()) {
            Session::flash('success', Translation::get('account_successful_activated'));
            return new RedirectResponse('/inloggen');
        }

        Session::flash('error', Translation::get('account_unsuccessful_activated'));
        return new RedirectResponse('/registreren');
    }

    /**
     * Proceed the user call from the method create and try to log the user in as admin.
     *
     * @return RedirectResponse
     */
    public function login()
    {
        $login = new Login();

        $path = '/inloggen';
        if (CSRF::validate() && $login->check()) {
            // try to send the user to the reservation form or sign up for meet the expert page
            $path = Session::get('path');
            unset($_SESSION['path']);

            if (empty($path)) {
                $path = '/';
            }
        }

        return new RedirectResponse($path);
    }

    /**
     * Show the page to edit the account
     *
     * @return View
     */
    public function edit()
    {
        $title = Translation::get('account_page_title');
        $account = $this->_user->account;

        return new View('account/edit', compact('title', 'account'));
    }

    /**
     * Proceed the user call from the method edit and try to update the user.
     *
     * @return RedirectResponse|View
     */
    public function update()
    {
        $updateUser = new UpdateUser($this->_user->getID(), $this->_user->account);
        if (CSRF::validate() && $updateUser->execute()) {
            return new RedirectResponse('/account/bewerken');
        }

        return $this->edit();
    }

    /**
     * Log the user out.
     *
     * @return RedirectResponse
     */
    public function logout()
    {
        return $this->_user->logout('/inloggen');
    }
}
