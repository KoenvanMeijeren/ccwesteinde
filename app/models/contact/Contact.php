<?php


namespace App\model\contact;

use App\contracts\models\EditModel;
use App\model\admin\contact\Contact as ContactPerson;
use App\model\admin\settings\Settings;
use App\services\core\Mail;
use App\services\core\Request;
use App\services\core\Translation;
use App\services\exceptions\CustomException;
use App\services\security\CSRF;
use App\services\security\Recaptcha;
use App\services\session\Session;

class Contact implements EditModel
{
    /**
     * The recaptcha class
     *
     * @var Recaptcha
     */
    private $recaptcha;

    /**
     * The the contact person.
     *
     * @var object
     */
    private $contact;

    /**
     * The email of the contact requester.
     *
     * @var string
     */
    private $email;

    /**
     * The subject of the contact request.
     *
     * @var string
     */
    private $subject;

    /**
     * The message of the contact request.
     *
     * @var string
     */
    private $message;

    /**
     * Construct the contact request.
     */
    public function __construct()
    {
        $request = new Request();
        $this->recaptcha = new Recaptcha($request);
        $contact = new ContactPerson();
        $this->contact = $contact->get();
        $this->email = $request->post('email');
        $this->subject = $request->post('subject');
        $this->message = $request->post('message');
    }

    /**
     * Insert the account.
     *
     * @return bool
     */
    public function execute()
    {
        if ($this->validateInput()) {
            try {
                $mail = new Mail();
                $settings = new Settings();
                $message = $this->message;

                $name = $settings->get('companyName') . ': ' . ($this->contact->branch_name ?? '') . ' - ' . ($this->contact->contact_name ?? '');
                $mail->addAddress($this->contact->contact_email ?? '', $name);
                $mail->setFrom($this->email, $settings->get('companyName'));

                $mail->setBody($this->subject, 'contact', compact('message'));
                $mail->send();
            } catch (\Exception $exception) {
                CustomException::handle($exception);
            }
            return true;
        }

        return false;
    }

    /**
     * Validate the input
     */
    private function validateInput()
    {
        if (empty($this->subject) || empty($this->email) || empty($this->contact) || empty($this->message)) {
            Session::flash('error', Translation::get('form_message_for_required_fields'));
            return false;
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            Session::flash('error', Translation::get('form_invalid_email_message'));
            return false;
        }

        if (!is_string($this->subject) || !is_string($this->message)) {
            Session::flash('error', Translation::get('form_invalid_data'));
            return false;
        }

        if (!$this->recaptcha->validate()) {
            return false;
        }

        if (!CSRF::validate()) {
            return false;
        }

        return true;
    }
}
