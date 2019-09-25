<?php


namespace App\controllers\admin;

use App\contracts\controllers\AccountControllerInterface;
use App\model\admin\account\UpdateUser;
use App\model\admin\account\User;
use App\services\core\Router;
use App\services\core\Translation;
use App\services\core\View;
use App\services\response\RedirectResponse;
use App\services\security\CSRF;
use App\services\session\Session;

class AccountController implements AccountControllerInterface
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
     * Overview of the account.
     *
     * @return View
     */
    public function index()
    {
        $title = Translation::get('admin_account_maintenance_title');
        $account = $this->_user->account;
        $rights = $this->_user->getRights();

        return new View('admin/account/index', compact('title', 'account', 'rights'));
    }

    /**
     * Proceed the user call from the method index and update the account.
     *
     * @return RedirectResponse|View
     */
    public function update()
    {
        $id = intval(Router::getWildcard());
        $updateUser = new UpdateUser($id, $this->_user->account);

        if (CSRF::validate() && $updateUser->execute()) {
            return new RedirectResponse('/admin/user/account');
        }

        return $this->index();
    }
}
