<?php


namespace App\services\core;

use App\services\security\Encrypt;
use Cake\Chronos\Chronos;

class Cookie
{
    /**
     * The expiring time of the cookie.
     *
     * @var int
     */
    private $expiringTime;

    /**
     * Construct the cookie
     *
     * @param int $expiringTime The expiring time of the cookie
     */
    public function __construct(int $expiringTime = 365 * 24 * 60 * 60)
    {
        $this->expiringTime = $expiringTime;
    }

    /**
     * Save data in the cookie based on the given key.
     *
     * @param string $key   The key of the cookie item.
     * @param mixed  $value The value of the key.
     *
     * @return void
     */
    public function save(string $key, $value)
    {
        Validate::var($value)->isScalar()->isNotEmpty();
        if (!isset($_COOKIE[$key])) {
            $sanitize = new Sanitize($value);
            $encrypt = new Encrypt($sanitize->data());

            setcookie($key, $encrypt->encrypt(), time() + $this->expiringTime, '/');
        }
    }

    /**
     * Get data which is stored in the cookie. And unset it if specified.
     *
     * @param string $key The key for searching to the corresponding session value.
     *
     * @return mixed
     */
    public static function get(string $key)
    {
        if (isset($_COOKIE[$key]) && !empty($_COOKIE[$key])) {
            $sanitize = new Sanitize($_COOKIE[$key]);
            $encrypt = new Encrypt($sanitize->data());
            $value = $encrypt->decrypt();

            return $value;
        }

        return '';
    }

    /**
     * Unset the cookie.
     *
     * @param string $key
     * @param string $value
     *
     * @return void
     */
    public function destroy(string $key, string $value)
    {
        setcookie($key, $value, time() - $this->expiringTime, '/');
    }
}
