<?php


namespace App\model\admin\landscape;

use App\contracts\models\branch\BranchModel;
use App\model\admin\page\Slug;
use App\services\core\Request;
use App\services\core\Router;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\session\Session;

class Landscape implements BranchModel
{
    /**
     * The id of the landscape
     *
     * @var int
     */
    protected $id = 0;

    /**
     * The slug id of the landscape
     *
     * @var int
     */
    protected $slugID = 0;

    /**
     * The name of the landscape
     *
     * @var string
     */
    protected $name = '';

    /**
     * Construct the landscape
     */
    public function __construct()
    {
        $request = new Request();

        $this->id = intval(Router::getWildcard());
        $this->name = $request->post('name');

        $slug = new Slug(0, 'landscape', true);
        $slug = $slug->getByName();
        $this->slugID = $slug->slug_ID ?? 0;
    }

    /**
     * Get a landscape by id.
     *
     * @return object
     */
    public function get()
    {
        $landscape = DB::table('entity')
            ->select('entity_ID', 'entity_name')
            ->where('entity_ID', '=', $this->id)
            ->where('entity_is_deleted', '=', 0)
            ->where('entity_slug_ID', '=', $this->slugID)
            ->execute()
            ->first();

        return $landscape;
    }

    /**
     * Get a landscape by name.
     *
     * @return object
     */
    public function getByName()
    {
        $landscape = DB::table('entity')
            ->select('entity_ID', 'entity_name')
            ->where('entity_name', '=', $this->name)
            ->where('entity_slug_ID', '=', $this->slugID)
            ->where('entity_is_deleted', '=', 0)
            ->execute()
            ->first();

        return $landscape;
    }

    /**
     * Get a landscape by id.
     *
     * @return array
     */
    public function getAll()
    {
        $landscapes = DB::table('entity')
            ->select('entity_ID', 'entity_name')
            ->where('entity_slug_ID', '=', $this->slugID)
            ->where('entity_is_deleted', '=', 0)
            ->orderBy('DESC', 'entity_ID')
            ->execute()
            ->all();

        return $landscapes;
    }

    /**
     * Soft delete a specific landscape by id.
     *
     * @return bool
     */
    public function softDelete()
    {
        $isLandscapeAttachedToContact = DB::table('entity', 1)
            ->select('entity_ID')
            ->innerJoin('contact', 'entity_ID', 'contact_landscape_ID')
            ->where('entity_ID', '=', $this->id)
            ->where('entity_slug_ID', '=', $this->slugID)
            ->where('contact_is_deleted', '=', 0)
            ->limit(1)
            ->execute()
            ->first();

        if (!empty($isLandscapeAttachedToContact)) {
            Session::flash('error', Translation::get('landscape_is_attached_to_contact'));
            return false;
        }


        $softDeleted = DB::table('entity')
            ->softDelete('entity_is_deleted')
            ->where('entity_ID', '=', $this->id)
            ->execute()
            ->isSuccessful();

        if ($softDeleted && empty($this->get())) {
            Session::flash('success', Translation::get('landscape_successful_deleted'));
            return true;
        }

        Session::flash('error', Translation::get('landscape_unsuccessful_deleted'));
        return false;
    }
}
