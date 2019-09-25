<?php


namespace App\model\account;

use App\contracts\models\student\StudentModelInterface;
use App\model\admin\settings\Settings;
use App\services\core\Request;
use App\services\database\DB;
use App\services\exceptions\CustomException;

class Student implements StudentModelInterface
{
    /**
     * The name of the student.
     *
     * @var string
     */
    protected $name;

    /**
     * The education of the account.
     *
     * @var string
     */
    protected $education;

    /**
     * The email of the student.
     *
     * @var string
     */
    protected $email;

    /**
     * The password of the student.
     *
     * @var string
     */
    protected $password;

    /**
     * The confirmation password of the student.
     *
     * @var string
     */
    protected $confirmationPassword;

    /**
     * The verification token for the student.
     *
     * @var string
     */
    protected $verificationToken;

    /**
     * Construct the student
     */
    public function __construct()
    {
        $request = new Request();
        $settings = new Settings();

        $this->name = $request->post('name');
        $this->education = $request->post('education');
        $this->email = $request->post('frontPieceEmail').'@'.$settings->get('studentEmail');
        $this->password = $request->post('password');
        $this->confirmationPassword = $request->post('confirmPassword');

        try {
            // try to generate a random string of 99 characters
            $this->verificationToken = bin2hex(random_bytes(99));
        } catch (\Exception $exception) {
            CustomException::handle($exception);
        }
    }

    /**
     * Get a specific account by email.
     *
     * @return object|null
     */
    public function getByEmail()
    {
        $account = DB::table('account')
            ->select('*')
            ->where('account_email', '=', $this->email)
            ->where('account_is_deleted', '=', 0)
            ->execute()
            ->first();

        return $account;
    }
}
