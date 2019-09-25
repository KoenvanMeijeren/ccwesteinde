<?php

namespace App\contracts;

interface URLInterface
{
    /**
     * Get the url.
     *
     * @return string
     */
    public static function getUrl();

    /**
     * Get the previous url.
     *
     * @return string
     */
    public static function getPreviousUrl();

    /**
     * Redirect to an specific url.
     *
     * @param string $url The url to redirect to.
     *
     * @return void
     */
    public static function redirect(string $url);

    /**
     * Refresh the page.
     *
     * @param string $url         The url to refresh.
     * @param int    $refreshTime The refresh time of the page.
     *
     * @return void
     */
    public static function refresh(string $url, int $refreshTime);

    /**
     * Get the request method.
     *
     * @return string
     */
    public static function method();
}
