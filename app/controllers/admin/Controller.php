<?php


namespace App\controllers\admin;

use App\contracts\controllers\LoginControllerInterface;
use App\model\admin\account\Login;
use App\model\admin\account\User;
use App\model\admin\accounts\Account;
use App\services\core\Translation;
use App\services\core\View;
use App\services\response\RedirectResponse;
use App\services\security\CSRF;

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
     * Overview of all the items.
     *
     * @return View|RedirectResponse
     */
    public function index()
    {
        $title = Translation::get('login_page_title');

        // if user is logged in, redirect
        if ($this->_user->getRights() >= Account::ACCOUNT_RIGHTS_LEVEL_3) {
            return new RedirectResponse('/admin/dashboard');
        }

        return new View('admin/login/index', compact('title'));
    }

    /**
     * Proceed the user call from the method index and try to log the user in as admin.
     *
     * @return RedirectResponse
     */
    public function login()
    {
        $path = '/admin';
        $login = new Login();
        if (CSRF::validate() && $login->check()) {
            $path = '/admin/dashboard';
        }

        return new RedirectResponse($path);
    }

    /**
     * Log the user out.
     *
     * @return RedirectResponse
     */
    public function logout()
    {
        return $this->_user->logout();
    }
}
