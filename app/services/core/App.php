<?php


namespace App\services\core;

use App\services\exceptions\CustomException;
use App\services\session\Session;
use Cake\Chronos\Date;

class App
{
    /**
     * The location of the routes file.
     *
     * @var string
     */
    private $_routes;

    /**
     * Prepare the app.
     *
     * @param string $routes  The routes file location.
     */
    public function __construct(string $routes = 'web.php')
    {
        $this->_routes = $routes;

        date_default_timezone_set('Europe/Amsterdam');

        new Env();

        // time is calculated as the following: days - hours - minutes - seconds
        new Session(365 * 24 * 60 * 60, 365 * 24 * 60 * 60);

        new Translation();
    }

    /**
     * Load the website.
     *
     * @return void
     */
    public function run()
    {
        try {
            Router::load($this->_routes)->direct(URL::getUrl(), URL::method());

            $this->_logAppRequest(URL::getUrl(), URL::method());
        } catch (CustomException $error) {
            CustomException::handle($error);
        }
    }

    /**
     * Log the requested route.
     *
     * @param string $url         The live url of the app.
     * @param string $requestType The type of the request for the app.
     *
     * @return void
     */
    private function _logAppRequest(string $url, string $requestType)
    {
        if (empty($url)) {
            $url = 'home';
        }
        Log::info("Successful {$requestType} Request for page '{$url}' ");
    }
}
