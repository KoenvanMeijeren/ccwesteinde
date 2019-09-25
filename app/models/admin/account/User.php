<?php


namespace App\model\admin\account;

use App\contracts\models\account\UserModelInterface;
use App\model\admin\accounts\Account;
use App\services\core\Config;
use App\services\core\Cookie;
use App\services\core\Request;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\response\RedirectResponse;
use App\services\session\Session;

class User implements UserModelInterface
{
    /**
     * The account of the user.
     *
     * @var object
     */
    public $account;

    /**
     * The email of the user.
     *
     * @var string
     */
    protected $email;

    /**
     * The password of the user.
     *
     * @var string
     */
    protected $password;

    /**
     * The verification token of the user
     *
     * @var string
     */
    private $token;

    /**
     * Construct the user.
     */
    public function __construct()
    {
        // try to log the user in
        $this->logIn();

        $request = new Request();
        $email = $request->post('email');
        $password = $request->post('password');

        if (empty($email)) {
            $email = $request->get('email');
        }

        $this->token = $request->get('verificationToken');
        $this->email = $email;
        $this->password = $password;
        $this->account = $this->getAccount(intval(Session::get('id')));

        // check if the user is logged in
        if ($this->getRights() !== Account::ACCOUNT_RIGHTS_LEVEL_0
            && $this->getRights() !== Account::ACCOUNT_RIGHTS_LEVEL_1
            && $this->getRights() !== Account::ACCOUNT_RIGHTS_LEVEL_2
            && $this->getRights() !== Account::ACCOUNT_RIGHTS_LEVEL_3
            && $this->getRights() !== Account::ACCOUNT_RIGHTS_LEVEL_4
        ) {
            $this->logout();
        }
    }

    /**
     * Get a specific account.
     *
     * @param int $id The id the user.
     *
     * @return object|null
     */
    public function getAccount(int $id)
    {
        $account = DB::table('account')
            ->select('*')
            ->where('account_ID', '=', $id)
            ->where('account_is_deleted', '=', 0)
            ->where('account_is_activated', '=', 1)
            ->execute()
            ->first();

        return $account;
    }

    /**
     * Get an specific account by an given email
     *
     * @return object|null
     */
    public function getAccountByEmail()
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
     * Activate the student account.
     *
     * @return bool
     */
    public function activate()
    {
        if (!empty($this->email) && !empty($this->token)) {
            $activated = DB::table('account')
                ->update(['account_is_activated' => 1])
                ->where('account_email', '=', $this->email)
                ->where('account_verification_token', '=', $this->token)
                ->execute()
                ->isSuccessful();

            return $activated;
        }

        return false;
    }

    /**
     * Get the id of the user.
     *
     * @return int
     */
    public function getID()
    {
        return intval($this->account->account_ID ?? 0);
    }

    /**
     * Get the rights of the user.
     *
     * @return int
     */
    public function getRights()
    {
        return intval($this->account->account_rights ?? 0);
    }

    /**
     * Log the user out.
     *
     * @param string $path The path to redirect to.
     *
     * @return RedirectResponse
     */
    public function logout(string $path = '/admin')
    {
        unset($_SESSION['id']);

        $cookie = new Cookie();
        $cookie->destroy('rememberMe', Cookie::get('rememberMe'));

        if (isset($_SESSION['id'])) {
            session_unset();
            session_destroy();
        }

        Session::flash('success', Translation::get('admin_logout_message'));
        return new RedirectResponse($path);
    }


    /**
     * Store the login token for the user
     *
     * @param int    $id    The id of the user.
     * @param string $token The login token from the user.
     *
     * @return void
     */
    protected function storeToken(int $id, string $token)
    {
        DB::table('account')
            ->update(['account_login_token' => $token])
            ->where('account_ID', '=', $id)
            ->where('account_is_deleted', '=', 0)
            ->execute();
    }

    /**
     * Get the token by user id
     *
     * @param int $id The id of the user.
     *
     * @return string
     */
    private function getToken(int $id)
    {
        $user = DB::table('account')
            ->select('account_login_token')
            ->where('account_ID', '=', $id)
            ->where('account_is_deleted', '=', 0)
            ->execute()
            ->first();

        return $user->account_login_token ?? '';
    }

    /**
     * Log the user in
     *
     * @return void
     */
    private function logIn()
    {
        $cookie = Cookie::get('rememberMe');
        if (!empty($cookie)) {
            list($user, $token, $mac) = explode(':', $cookie);

            if (!hash_equals(
                hash_hmac(
                    'sha256',
                    $user . ':' . $token,
                    Config::get('secretKey')
                ),
                $mac
            )
            ) {
                return;
            }

            $userToken = $this->getToken($user);
            if (hash_equals($userToken, $token)) {
                Session::save('id', $user);

                return;
            }
        }
    }
}
