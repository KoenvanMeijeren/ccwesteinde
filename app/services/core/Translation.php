<?php


namespace App\services\core;

use App\services\session\Session;

class Translation
{
    const DUTCH_LANGUAGE_ID = 1;
    const ENGLISH_LANGUAGE_ID = 2;

    /**
     * The translation items loaded based on the current language id.
     *
     * @var array
     */
    private static $_translation = [];

    /**
     * Set the language based on the domain extension.
     */
    public function __construct()
    {
        $this->_makeSureThereIsALanguageID();
        if (intval(Session::get('languageID')) === self::DUTCH_LANGUAGE_ID) {
            Config::set('languageID', 1);
            Config::set('languageCode', 'nl');
            Config::set('languageName', 'Dutch');
            setlocale(LC_ALL, 'nl_NL');
            setlocale(LC_MONETARY, 'de_DE');
            loadFile(RESOURCES_PATH . '/language/dutch/dutch_translations.php');
        } elseif (intval(Session::get('languageID')) === self::ENGLISH_LANGUAGE_ID) {
            Config::set('languageID', 2);
            Config::set('languageCode', 'en');
            Config::set('languageName', 'English');
            setlocale(LC_ALL, 'en_US.UTF-8');
            setlocale(LC_MONETARY, 'en_US');
            loadFile(RESOURCES_PATH . '/language/english/english_translations.php');
        }
    }

    /**
     * Set a new translation item.
     *
     * @param string $key   The key to save the value in.
     * @param mixed  $value The value of the key.
     *
     * @return void
     */
    public static function set(string $key, $value)
    {
        if (!isset(self::$_translation[$key]) && is_scalar($value)) {
            $sanitize = new Sanitize($value);
            self::$_translation[$key] = $sanitize->data();
        }
    }

    /**
     * Get a specific stored config item.
     *
     * @param string $key The key to search for the corresponding value in the config array.
     *
     * @return string
     */
    public static function get(string $key)
    {
        if (isset(self::$_translation[$key]) && is_scalar(self::$_translation[$key])) {
            $sanitize = new Sanitize(self::$_translation[$key]);
            $translation = $sanitize->data();
            return htmlspecialchars_decode($translation);
        }

        return '';
    }

    /**
     * Make sure that there is a language id.
     *
     * @return void
     */
    private function _makeSureThereIsALanguageID()
    {
        if (empty(Session::get('languageID'))) {
            if (strstr(URL::getDomainExtension(), 'localhost')
                || strstr(URL::getDomainExtension(), 'nl')
            ) {
                Session::save('languageID', 1);
            } elseif (strstr(URL::getDomainExtension(), 'com')) {
                Session::save('languageID', 2);
            }
        }
    }
}
