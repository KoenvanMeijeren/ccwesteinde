<?php


namespace App\model\admin\account;

use App\contracts\models\account\LoginModelInterface;
use App\services\core\Config;
use App\services\core\Cookie;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\exceptions\CustomException;
use App\services\session\Session;

class Login extends User implements LoginModelInterface
{
    /**
     * The maximum number of failed log ins.
     */
    const MAX_FAILED_LOG_INS = 3;

    /**
     * The account of the user if it has been found.
     *
     * @var object
     */
    private $_account;

    /**
     * Construct the login.
     */
    public function __construct()
    {
        parent::__construct();

        $this->_account = $this->getAccountByEmail();
    }

    /**
     * Check if the user is logged in.
     *
     * @return bool
     */
    public function check()
    {
        if ($this->_isAccountBlocked()) {
            Session::flash('error', Translation::get('login_failed_blocked_account_message'));
            return false;
        }

        if (password_verify($this->password, $this->_account->account_password ?? '')) {
            if (isset($_SESSION['id'])) {
                unset($_SESSION['id']);
            }

            try {
                // try to generate a random string of 200 characters and store the token
                $token = bin2hex(random_bytes(200));
                $this->storeToken(($this->_account->account_ID ?? 0), $token);

                // save the cookie
                $cookieClass = new Cookie(365 * 24 * 60 * 60);
                $cookie = ($this->_account->account_ID ?? 0) . ':' . $token;

                // set the mac
                $mac = hash_hmac('sha256', $cookie, Config::get('secretKey'));
                $cookie .= ':' . $mac;

                $cookieClass->save('rememberMe', $cookie);
            } catch (\Exception $exception) {
                CustomException::handle($exception);
            }
            Session::save('id', ($this->_account->account_ID ?? 0));

            if (password_needs_rehash($this->_account->account_password ?? '', PASSWORD_BCRYPT)) {
                $this->_rehashPassword();
            }

            $this->_updateFailedLogIns(true);

            Session::flash('success', Translation::get('login_successful_message'));
            return true;
        }

        $this->_updateFailedLogIns();
        $this->_blockAccount();

        Session::flash('error', Translation::get('login_failed_message'));
        return false;
    }

    /**
     * Rehash the password.
     *
     * @return bool
     */
    private function _rehashPassword()
    {
        $encryptedPassword = password_hash($this->_account->account_password ?? '', PASSWORD_BCRYPT);
        $isUpdated = DB::table('account')
            ->update(
                [
                    'account_password' => $encryptedPassword
                ]
            )
            ->where('account_ID', '=', $this->_account->account_ID ?? 0)
            ->execute()
            ->isSuccessful();

        return $isUpdated;
    }

    /**
     * Update the failed logged ins for a specific account.
     *
     * @param bool $reset If this is specified reset the amount of failed log ins.
     *
     * @return void
     */
    private function _updateFailedLogIns(bool $reset = false)
    {
        if ($reset) {
            DB::table('account')
                ->update(['account_failed_login' => 0])
                ->where('account_email', '=', $this->email)
                ->where('account_rights', '!=', 5)
                ->where('account_is_deleted', '=', 0)
                ->execute()
                ->isSuccessful();

            return;
        }

        if (intval($this->_account->account_failed_login ?? 0) < self::MAX_FAILED_LOG_INS) {
            $currentFailedLogIns = intval($this->_account->account_failed_login ?? 0) + 1;

            DB::table('account')
                ->update(
                    [
                        'account_failed_login' => $currentFailedLogIns
                    ]
                )
                ->where('account_email', '=', $this->email)
                ->where('account_rights', '!=', 5)
                ->where('account_is_deleted', '=', 0)
                ->execute()
                ->isSuccessful();

            return;
        }

        return;
    }

    /**
     * Block the account if the specified condition is true.
     *
     * @return bool
     */
    private function _blockAccount()
    {
        $updated = false;
        if (intval($this->_account->account_failed_login ?? 0) >= self::MAX_FAILED_LOG_INS) {
            $updated = DB::table('account')
                ->update(
                    [
                        'account_failed_login' => 0,
                        'account_is_blocked' => 1
                    ]
                )
                ->where('account_email', '=', $this->email)
                ->where('account_rights', '!=', 5)
                ->where('account_is_deleted', '=', 0)
                ->execute()
                ->isSuccessful();
        }

        return $updated;
    }


    /**
     * Check if the account is blocked.
     *
     * @return bool
     */
    private function _isAccountBlocked()
    {
        if (intval($this->_account->account_is_blocked ?? 0) === 1) {
            return true;
        }

        return false;
    }
}
