<?php


namespace App\services\security;

use App\services\core\Config;
use App\services\core\Request;
use App\services\core\Translation;
use App\services\session\Session;

class Recaptcha
{
    /**
     * The http request for google recaptcha.
     *
     * @var array
     */
    private $_query = [];

    /**
     * Build the recaptcha http request.
     *
     * @param Request $request The request for the post item.
     */
    public function __construct(Request $request)
    {
        $recaptcha = http_build_query(
            array(
                'secret' => Config::get('recaptcha_secret_key'),
                'response' => $request->post('g-recaptcha-response'),
                'remoteip' => $_SERVER['REMOTE_ADDR'] ?? ''
            )
        );

        $this->_query = array(
            'http' =>
                array(
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $recaptcha
                )
        );
    }

    public function validate()
    {
        $context = stream_context_create($this->_query);
        $response = file_get_contents(
            'https://www.google.com/recaptcha/api/siteverify',
            false,
            $context
        );

        if (is_string($response)) {
            $recaptchaResult = json_decode($response);
        }

        if (isset($recaptchaResult) && $recaptchaResult->success) {
            return true;
        }

        Session::flash('error', Translation::get('failed_recaptcha_check_message'));
        return false;
    }
}
