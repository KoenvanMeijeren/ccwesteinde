<?php

namespace App\services\core;

use App\contracts\URLInterface;
use Cake\Chronos\Chronos;
use Cake\Chronos\Date;

abstract class URL implements URLInterface
{
    /**
     * Get the url.
     *
     * @return string
     */
    public static function getUrl()
    {
        $url = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);

        return $url;
    }

    /**
     * Get the previous url.
     *
     * @return string
     */
    public static function getPreviousUrl()
    {
        $url = trim(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH), '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);

        return $url;
    }

    /**
     * Get the domain extension.
     *
     * @return string
     */
    public static function getDomainExtension()
    {
        $host = $_SERVER['HTTP_HOST'] ?? '';
        $hostExploded = explode('.', $host);
        $arrayKeyLast = array_key_last($hostExploded);

        return $hostExploded[$arrayKeyLast] ?? 'nl';
    }

    /**
     * Redirect to an specific url.
     *
     * @param string $url The url to redirect.
     *
     * @return void
     */
    public static function redirect(string $url)
    {
        header('Location: ' . $url);
        return;
    }

    /**
     * Refresh the page.
     *
     * @param string $url         The url to refresh.
     * @param int    $refreshTime The refresh time.
     *
     * @return void
     */
    public static function refresh(string $url, int $refreshTime)
    {
        $url = trim(parse_url($url, PHP_URL_PATH), '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);

        header("Refresh: {$refreshTime}; URL=/" . $url);
    }

    /**
     * Get the request method.
     *
     * @return string
     */
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'] ?? '';
    }
}
