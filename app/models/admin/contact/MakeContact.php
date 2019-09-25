<?php


namespace App\model\admin\contact;

use App\contracts\models\EditModel;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\session\Session;

class MakeContact extends Contact implements EditModel
{
    /**
     * The parameters to be inserted.
     *
     * @var array
     */
    private $parameters;

    /**
     * Execute the making of the contact.
     */
    public function execute()
    {
        if ($this->prepare()) {
            $lastInsertedID = DB::table('contact')
                ->insert($this->parameters)
                ->execute()
                ->getLastInsertedId();
            $this->id = $lastInsertedID;

            if (!empty($this->get())) {
                Session::flash('success', Translation::get('contact_successfully_created'));
                return true;
            }

            Session::flash('error', Translation::get('contact_unsuccessfully_created'));
        }

        return false;
    }

    /**
     * Prepare the making of the contact.
     *
     * @return bool
     */
    private function prepare()
    {
        if ($this->validate()) {
            $this->parameters['contact_branch_ID'] = $this->branchID;
            $this->parameters['contact_landscape_ID'] = $this->landscapeID;
            $this->parameters['contact_name'] = $this->name;
            $this->parameters['contact_email'] = $this->email;

            return true;
        }

        return false;
    }

    /**
     * Validate the input.
     *
     * @return bool
     */
    private function validate()
    {
        if (empty($this->name)
            || empty($this->branchID)
            || empty($this->email)
        ) {
            Session::flash('error', Translation::get('form_message_for_required_fields'));
            return false;
        }

        if (!is_string($this->name)
            || !is_int($this->branchID)
            || !filter_var($this->email, FILTER_VALIDATE_EMAIL)
        ) {
            Session::flash('error', Translation::get('form_invalid_date'));
            return false;
        }

        if (!empty($this->getByEmail())) {
            Session::flash('error', Translation::get('form_email_already_exists'));
            return false;
        }

        return true;
    }
}
