<?php


namespace App\services\session;

use App\services\core\Log;
use App\services\core\Sanitize;
use App\services\core\URL;
use App\services\core\Validate;
use App\services\security\Encrypt;

class Session extends Builder
{
    /**
     * Set the session with a specified expiring time.
     *
     * @param int    $expiringTime The expiring time of the session.
     * @param int    $refreshTime  The refresh time of the app.
     */
    public function __construct(int $expiringTime = 1 * 1 * 60 * 60, int $refreshTime = 3600)
    {
        parent::__construct($expiringTime, $refreshTime);
    }

    /**
     * Save data in the session based on the given key.
     *
     * @param string $key   The key of the session item.
     * @param mixed  $value The value of the key.
     *
     * @return void
     */
    public static function save(string $key, $value)
    {
        Validate::var($value)->isScalar()->isNotEmpty();
        if (!isset($_SESSION[$key])) {
            $sanitize = new Sanitize($value);
            $encrypt = new Encrypt($sanitize->data());
            $_SESSION[$key] = $encrypt->encrypt();
        }
    }

    /**
     * Flash data in the session based on the given key.
     *
     * @param string $key   The key of the session item.
     * @param mixed  $value The value of the key.
     *
     * @return void
     */
    public static function flash(string $key, $value)
    {
        Validate::var($value)->isScalar()->isNotEmpty();
        $sanitize = new Sanitize($value);
        $encrypt = new Encrypt($sanitize->data());
        $_SESSION[$key] = $encrypt->encrypt();
    }

    /**
     * Get data which is stored in the session. And unset it if specified.
     *
     * @param string $key   The key for searching to the corresponding session value.
     * @param bool   $unset Shall the session value be unset?
     *
     * @return mixed
     */
    public static function get(string $key, bool $unset = false)
    {
        if (isset($_SESSION[$key]) && !empty($_SESSION[$key])) {
            $sanitize = new Sanitize($_SESSION[$key]);
            $encrypt = new Encrypt($sanitize->data());
            $value = $encrypt->decrypt();

            if ($unset) {
                unset($_SESSION[$key]);
            }

            self::_logSessionRequest($key, strval($value));
            return $value;
        }

        return '';
    }

    /**
     * Log the session data.
     *
     * @param string $key   The key to search for the corresponding value.
     * @param string $value The value of the key.
     *
     * @return void
     */
    private static function _logSessionRequest(string $key, string $value)
    {
        if ($key === 'error') {
            Log::info("Failed " . URL::method() . " request for page '" . URL::getUrl() . "' with message '{$value}'");
        }

        if ($key === 'success') {
            Log::info("Successful " . URL::method() . " request for page '" . URL::getUrl() . "' with message '{$value}'");
        }
    }
}
