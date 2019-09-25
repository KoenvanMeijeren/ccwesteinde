<?php


namespace App\services\core;

use App\model\admin\settings\Settings;
use PHPMailer\PHPMailer\PHPMailer;

class Mail
{
    /**
     * The headers of the mail
     *
     * @var string
     */
    private $_headers;

    /**
     * The receivers of the mail
     *
     * @var string
     */
    private $_receivers;

    /**
     * Set the subject
     *
     * @var string
     */
    private $_subject;

    /**
     * Set the body of the mail
     *
     * @var string
     */
    private $_body;

    /**
     * The settings object.
     *
     * @var Settings
     */
    private $_settings;

    /**
     * Construct the PHPMailer.
     */
    public function __construct()
    {
        $this->_settings = new Settings();

        $this->_headers = "MIME-Version: 1.0" . "\r\n";
        $this->_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    }

    /**
     * Set the recipients for the mail.
     *
     * @param string $address The address of the receiver.
     * @param string $name    The name of the receiver.
     *
     * @return void
     * @throws \Exception
     */
    public function addAddress(string $address, string $name = '')
    {
        $this->_receivers .= $address;
    }

    /**
     * Set the reply to for the mail.
     *
     * @param string $address The address of the receiver.
     * @param string $name    The name of the receiver.
     *
     * @return void
     * @throws \Exception
     */
    public function setFrom(string $address, string $name = '')
    {
        $this->_headers .= 'From: ' . $name . ' <' . $address . '>' . "\r\n";
    }

    /**
     * Set the mail body.
     *
     * @param string $subject  The subject of the mail.
     * @param string $htmlBody The html body of the mail.
     * @param mixed  $vars     The vars to use in the mail.
     *
     * @return void
     */
    public function setBody(string $subject, $htmlBody, $vars = null)
    {
        if (!empty($vars)) {
            extract($vars);
        }

        $this->_subject = $subject;

        // set the html body
        if (file_exists(RESOURCES_PATH . "/partials/mails/{$htmlBody}.view.php")) {
            $htmlBody = file_get_contents(RESOURCES_PATH . "/partials/mails/{$htmlBody}.view.php");
            $htmlBody = str_replace('{token}', $token ?? '', $htmlBody);
            $htmlBody = str_replace('{email}', $email ?? '', $htmlBody);
            $htmlBody = str_replace('{subject}', $subject ?? '', $htmlBody);
            $htmlBody = str_replace('{message}', $message ?? '', $htmlBody);
            $htmlBody = str_replace('{workspaceName}', $workspaceName ?? '', $htmlBody);
            $htmlBody = str_replace('{date}', $date ?? '', $htmlBody);
            $htmlBody = str_replace('{time}', $time ?? '', $htmlBody);
            $htmlBody = str_replace('{title}', $title ?? '', $htmlBody);
            $htmlBody = str_replace('{location}', $location ?? '', $htmlBody);
            $this->_body = strval($htmlBody);
        }
    }

    /**
     * Send a new mail.
     *
     * @return void
     */
    public function send()
    {
        if (Config::get('env') === 'production') {
            mail($this->_receivers, $this->_subject, $this->_body, $this->_headers);
        }
    }
}
