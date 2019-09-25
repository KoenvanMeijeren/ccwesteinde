<?php


namespace App\services\core;

abstract class Config
{
    /**
     * The config items.
     *
     * @var array
     */
    private static $_config = [];

    /**
     * Set a new config item.
     *
     * @param string $key   The key to save the value in.
     * @param mixed  $value The value of the key.
     *
     * @return void
     */
    public static function set(string $key, $value)
    {
        if (!isset(self::$_config[$key])) {
            if (is_scalar($value)) {
                $sanitize = new Sanitize($value);
                self::$_config[$key] = $sanitize->data();
            }

            self::$_config[$key] = $value;
        }
    }

    /**
     * Get a specific stored config item.
     *
     * @param string $key The key to search for the corresponding value.
     *
     * @return mixed
     */
    public static function get(string $key)
    {
        if (isset(self::$_config[$key])) {
            if (is_scalar(self::$_config[$key])) {
                $sanitize = new Sanitize(self::$_config[$key]);

                return $sanitize->data();
            }

            return self::$_config[$key];
        }

        return '';
    }
}
