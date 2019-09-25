<?php


namespace App\model\admin\branch;

use App\contracts\models\branch\BranchModel;
use App\model\admin\page\Slug;
use App\services\core\Request;
use App\services\core\Router;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\session\Session;

class Branch implements BranchModel
{
    /**
     * The id of the branch
     *
     * @var int
     */
    protected $id = 0;

    /**
     * The slug id of the branch
     *
     * @var int
     */
    protected $slugID = 0;

    /**
     * The name of the branch
     *
     * @var string
     */
    protected $name = '';

    /**
     * Construct the branch
     */
    public function __construct()
    {
        $request = new Request();

        $this->id = intval(Router::getWildcard());
        $this->name = $request->post('name');

        $slug = new Slug(0, 'branch', true);
        $slug = $slug->getByName();
        $this->slugID = $slug->slug_ID ?? 0;
    }

    /**
     * Get a branch by id.
     *
     * @return object
     */
    public function get()
    {
        $branch = DB::table('entity')
            ->select('entity_ID', 'entity_name')
            ->where('entity_ID', '=', $this->id)
            ->where('entity_is_deleted', '=', 0)
            ->where('entity_slug_ID', '=', $this->slugID)
            ->execute()
            ->first();

        return $branch;
    }

    /**
     * Get a branch by name.
     *
     * @return object
     */
    public function getByName()
    {
        $branch = DB::table('entity')
            ->select('entity_ID', 'entity_name')
            ->where('entity_name', '=', $this->name)
            ->where('entity_slug_ID', '=', $this->slugID)
            ->where('entity_is_deleted', '=', 0)
            ->execute()
            ->first();

        return $branch;
    }

    /**
     * Get a branch by id.
     *
     * @return array
     */
    public function getAll()
    {
        $branches = DB::table('entity')
            ->select('entity_ID', 'entity_name')
            ->where('entity_slug_ID', '=', $this->slugID)
            ->where('entity_is_deleted', '=', 0)
            ->orderBy('DESC', 'entity_ID')
            ->execute()
            ->all();

        return $branches;
    }

    /**
     * Soft delete a specific branch by id.
     *
     * @return bool
     */
    public function softDelete()
    {
        $isBranchAttachedToContact = DB::table('entity', 1)
            ->select('entity_ID')
            ->innerJoin('contact', 'entity_ID', 'contact_branch_ID')
            ->where('entity_ID', '=', $this->id)
            ->where('entity_slug_ID', '=', $this->slugID)
            ->where('contact_is_deleted', '=', 0)
            ->limit(1)
            ->execute()
            ->first();

        if (!empty($isBranchAttachedToContact)) {
            Session::flash('error', Translation::get('branch_is_attached_to_contact'));
            return false;
        }


        $softDeleted = DB::table('entity')
            ->softDelete('entity_is_deleted')
            ->where('entity_ID', '=', $this->id)
            ->execute()
            ->isSuccessful();

        if ($softDeleted && empty($this->get())) {
            Session::flash('success', Translation::get('branch_successful_deleted'));
            return true;
        }

        Session::flash('error', Translation::get('branch_unsuccessful_deleted'));
        return false;
    }
}
