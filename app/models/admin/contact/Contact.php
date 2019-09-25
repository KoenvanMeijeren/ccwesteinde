<?php


namespace App\model\admin\contact;

use App\contracts\models\Model;
use App\services\core\Request;
use App\services\core\Router;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\session\Session;

class Contact implements Model
{
    /**
     * The id of the contact.
     *
     * @var int
     */
    protected $id = 0;

    /**
     * The branch id of the contact.
     *
     * @var int
     */
    protected $branchID = 0;

    /**
     * The landscape id of the contact.
     *
     * @var int
     */
    protected $landscapeID = 0;

    /**
     * The name of the contact.
     *
     * @var string
     */
    protected $name = '';

    /**
     * The email of the contact.
     *
     * @var string
     */
    protected $email = '';

    /**
     * Construct the contact.
     */
    public function __construct()
    {
        $request = new Request();

        $this->id = intval(Router::getWildcard());
        $this->branchID = intval($request->post('branchID'));
        $this->landscapeID = intval($request->post('landscapeID'));
        $this->name = $request->post('name');
        $this->email = $request->post('email');

        if (empty($this->id)) {
            $this->id = intval($request->post('branch'));
        }
    }

    /**
     * Get a contact by id.
     *
     * @return object
     */
    public function get()
    {
        $contact = DB::table('contact', 2)
            ->select(
                'contact_ID',
                'contact_branch_ID',
                'entityA.entity_name AS branch_name',
                'contact_landscape_ID',
                'entityB.entity_name AS landscape_name',
                'contact_name',
                'contact_email'
            )
            ->innerJoin('entity AS entityA', 'entityA.entity_ID', 'contact_branch_ID')
            ->innerJoin('entity AS entityB', 'entityB.entity_ID', 'contact_landscape_ID')
            ->where('contact_ID', '=', $this->id)
            ->where('contact_is_deleted', '=', 0)
            ->where('entityA.entity_is_deleted', '=', 0)
            ->where('entityB.entity_is_deleted', '=', 0)
            ->execute()
            ->first();

        return $contact;
    }

    /**
     * Get a contact by email.
     *
     * @return object
     */
    public function getByEmail()
    {
        $contact = DB::table('contact', 2)
            ->select(
                'contact_ID',
                'contact_branch_ID',
                'entityA.entity_name AS branch_name',
                'contact_landscape_ID',
                'entityB.entity_name AS landscape_name',
                'contact_name',
                'contact_email'
            )
            ->innerJoin('entity AS entityA', 'entityA.entity_ID', 'contact_branch_ID')
            ->innerJoin('entity AS entityB', 'entityB.entity_ID', 'contact_landscape_ID')
            ->where('contact_email', '=', $this->email)
            ->where('contact_is_deleted', '=', 0)
            ->where('entityA.entity_is_deleted', '=', 0)
            ->where('entityB.entity_is_deleted', '=', 0)
            ->execute()
            ->first();

        return $contact;
    }

    /**
     * Get all contacts.
     *
     * @return array
     */
    public function getAll()
    {
        $contacts = DB::table('contact')
            ->select(
                'contact_ID',
                'contact_branch_ID',
                'entityA.entity_name AS branch_name',
                'contact_landscape_ID',
                'entityB.entity_name AS landscape_name',
                'contact_name',
                'contact_email'
            )
            ->innerJoin('entity AS entityA', 'entityA.entity_ID', 'contact_branch_ID')
            ->innerJoin('entity AS entityB', 'entityB.entity_ID', 'contact_landscape_ID')
            ->where('contact_is_deleted', '=', 0)
            ->where('entityA.entity_is_deleted', '=', 0)
            ->where('entityB.entity_is_deleted', '=', 0)
            ->orderBy('DESC', 'contact_ID')
            ->execute()
            ->all();

        return $contacts;
    }

    /**
     * Soft delete a contact by id.
     *
     * @return bool
     */
    public function softDelete()
    {
        $softDeleted = DB::table('contact')
            ->softDelete('contact_is_deleted')
            ->where('contact_ID', '=', $this->id)
            ->execute()
            ->isSuccessful();

        if ($softDeleted && empty($this->get())) {
            Session::flash('success', Translation::get('contact_successful_deleted'));
            return true;
        }

        Session::flash('error', Translation::get('contact_unsuccessful_deleted'));
        return false;
    }
}
