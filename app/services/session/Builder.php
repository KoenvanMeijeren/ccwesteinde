<?php


namespace App\services\session;

use App\services\core\Config;
use App\services\core\Log;
use App\services\core\URL;
use App\services\core\Validate;
use Cake\Chronos\Chronos;

class Builder
{
    /**
     * The live url of the app.
     *
     * @var string
     */
    private $_liveUrl;

    /**
     * The expiring time of the session.
     *
     * @var int
     */
    private $_expiringTime;

    /**
     * The refresh time of the app.
     *
     * @var int
     */
    private $_refreshTime;

    /**
     * Set the session with a specified expiring time.
     *
     * @param int    $expiringTime The expiring time of the session.
     * @param int    $refreshTime  The refresh time of the app.
     */
    protected function __construct(int $expiringTime, int $refreshTime)
    {
        Validate::var($expiringTime)->isInt();
        $this->_expiringTime = $expiringTime;

        Validate::var($refreshTime)->isInt();
        $this->_refreshTime = $refreshTime;

        $this->_startSession();
        $this->_setRefreshSession();
        $this->_setCanarySession();
    }

    /**
     * Start the session.
     */
    private function _startSession()
    {
        if (!session_status() && Config::get('env') === 'development') {
            session_set_cookie_params(
                $this->_expiringTime, // Lifetime -- 0 means erase when browser closes
                '/',               // Which paths are these cookies relevant?
                '', // Only expose this to which domain?
                false,              // Only send over the network when TLS is used
                true               // Don't expose to Javascript
            );
        }

        if (!session_status() && Config::get('env') === 'production') {
            session_set_cookie_params(
                $this->_expiringTime, // Lifetime -- 0 means erase when browser closes
                '/',               // Which paths are these cookies relevant?
                '', // Only expose this to which domain?
                false,              // Only send over the network when TLS is used
                true               // Don't expose to Javascript
            );
        }

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Set the refresh time for the session.
     *
     * @return void
     */
    private function _setRefreshSession()
    {
        $now = new Chronos();
        if (empty(Session::get('time'))) {
            Session::save('time', $now->toDateTimeString());
        }

        $sessionCreatedAt = Session::get('time');
        $expired = new Chronos($sessionCreatedAt);
        $expired = $expired->addSeconds($this->_expiringTime);

        if (strtotime($now->toDateTimeString()) >= strtotime($expired->toDateTimeString())) {
            Log::info("The session is destroyed.");
            session_unset();
            session_destroy();

            new Session(Config::get('liveUrl'));
        }

        URL::refresh(URL::getUrl(), $this->_refreshTime);
    }

    /**
     * Regenerate session ID every five minutes.
     *
     * @return void
     */
    private function _setCanarySession()
    {
        if (!isset($_SESSION['canary'])) {
            session_regenerate_id(true);
            $_SESSION['canary'] = time();
        }

        if ($_SESSION['canary'] < time() - 300) {
            session_regenerate_id(true);
            $_SESSION['canary'] = time();
        }
    }
}
