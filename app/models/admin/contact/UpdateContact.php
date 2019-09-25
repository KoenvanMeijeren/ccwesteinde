<?php


namespace App\model\admin\contact;

use App\contracts\models\EditModel;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\session\Session;

class UpdateContact extends Contact implements EditModel
{
    /**
     * The parameters to be updated.
     *
     * @var array
     */
    private $parameters;

    /**
     * Execute the updating of the contact.
     */
    public function execute()
    {
        if ($this->prepare()) {
            $updated = DB::table('contact')
                ->update($this->parameters)
                ->where('contact_ID', '=', $this->id)
                ->execute()
                ->isSuccessful();

            if ($updated) {
                Session::flash('success', Translation::get('contact_successfully_updated'));
                return true;
            }

            Session::flash('error', Translation::get('contact_unsuccessfully_updated'));
        }

        return false;
    }

    /**
     * Prepare the updating of the contact.
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
        ) {
            Session::flash('error', Translation::get('form_message_for_required_fields'));
            return false;
        }

        if (!is_string($this->name)
            || !is_int($this->branchID)
        ) {
            Session::flash('error', Translation::get('form_invalid_date'));
            return false;
        }

        if (($this->get()->contact_email ?? 0) !== $this->email && !empty($this->getByEmail())) {
            Session::flash('error', Translation::get('form_email_already_exists'));
            return false;
        }

        return true;
    }
}
