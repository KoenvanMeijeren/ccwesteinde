<?php


namespace App\services\security;

use App\services\core\Translation;
use App\services\exceptions\CustomException;
use App\services\session\Session;
use Exception;
use ParagonIE\AntiCSRF\AntiCSRF;

class CSRF
{
    const ECHO_CSRF_TOKEN = false;

    /**
     * The antiCSRF object.
     *
     * @var AntiCSRF
     */
    private static $_csrf;

    /**
     * Add the token to the form and lock it to an URL.
     *
     * @param string $lockTo The request is locked to the given URL.
     *
     * @return string|void
     */
    public static function formToken(string $lockTo)
    {
        try {
            self::$_csrf = new AntiCSRF();

            return self::$_csrf->insertToken($lockTo, self::ECHO_CSRF_TOKEN);
        } catch (Exception $exception) {
            CustomException::handle($exception);
        }
    }

    /**
     * Check if the posted token is valid.
     *
     * @return bool
     */
    public static function validate()
    {
        $antiCSRF = new AntiCSRF();
        if ($antiCSRF->validateRequest()) {
            return true;
        }

        Session::flash('error', Translation::get('failed_csrf_check_message'));
        return false;
    }
}
