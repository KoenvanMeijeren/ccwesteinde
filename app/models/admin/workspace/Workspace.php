<?php


namespace App\model\admin\workspace;

use App\contracts\models\Model;
use App\services\core\Request;
use App\services\core\Router;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\session\Session;
use Cake\Chronos\Chronos;

class Workspace implements Model
{
    /**
     * The id of the workspace
     *
     * @var int
     */
    protected $id;

    /**
     * The name of the workspace
     *
     * @var string
     */
    protected $name;

    /**
     * The slug of the workspace
     *
     * @var string
     */
    protected $slug;

    /**
     * The slug id of the workspace
     *
     * @var int
     */
    protected $slugID;

    /**
     * Construct the workspace.
     */
    public function __construct()
    {
        $request = new Request();

        $this->id = intval(Router::getWildcard());
        $this->name = $request->post('name');

        $slug = 'werkplek';
        if (intval($request->post('space')) === 1) {
            $slug = 'vergaderruimte';
        }

        $this->slug = $slug;
        $this->slugID = intval($request->get('kind'));
    }

    /**
     * Get a workspace by id.
     *
     * @return object
     */
    public function get()
    {
        $workspace = DB::table('workspace', 1)
            ->select('workspace_ID', 'slug_name', 'workspace_name')
            ->innerJoin('slug', 'workspace_slug_ID', 'slug_ID')
            ->where('workspace_ID', '=', $this->id)
            ->where('workspace_is_deleted', '=', 0)
            ->where('slug_is_deleted', '=', 0)
            ->execute()
            ->first();

        return $workspace;
    }

    /**
     * Get a workspace by name.
     *
     * @return object
     */
    public function getByName()
    {
        $workspace = DB::table('workspace', 1)
            ->select('workspace_ID', 'slug_name', 'workspace_name')
            ->innerJoin('slug', 'workspace_slug_ID', 'slug_ID')
            ->where('workspace_name', '=', $this->name)
            ->where('workspace_is_deleted', '=', 0)
            ->where('slug_is_deleted', '=', 0)
            ->execute()
            ->first();

        return $workspace;
    }

    /**
     * Get a workspace by name.
     *
     * @return array
     */
    public function getUniqueRows()
    {
        $workspaces = DB::table('workspace', 1)
            ->selectDistinct('workspace_slug_ID', 'slug_name')
            ->innerJoin('slug', 'workspace_slug_ID', 'slug_ID')
            ->where('workspace_is_deleted', '=', 0)
            ->where('slug_is_deleted', '=', 0)
            ->execute()
            ->all();

        return $workspaces;
    }

    /**
     * Get all workspaces by slug id.
     *
     * @return array
     */
    public function getAllBySlug()
    {
        $workspaces = DB::table('workspace', 1)
            ->select('workspace_ID', 'slug_name', 'workspace_name')
            ->innerJoin('slug', 'workspace_slug_ID', 'slug_ID')
            ->where('workspace_is_deleted', '=', 0)
            ->where('slug_is_deleted', '=', 0)
            ->where('workspace_slug_ID', '=', $this->slugID)
            ->execute()
            ->all();

        return $workspaces;
    }

    /**
     * Get all workspaces.
     *
     * @return array
     */
    public function getAll()
    {
        $workspaces = DB::table('workspace', 1)
            ->select('workspace_ID', 'slug_name', 'workspace_name')
            ->innerJoin('slug', 'workspace_slug_ID', 'slug_ID')
            ->where('workspace_is_deleted', '=', 0)
            ->where('slug_is_deleted', '=', 0)
            ->orderBy('DESC', 'workspace_ID')
            ->execute()
            ->all();

        return $workspaces;
    }

    /**
     * Soft delete a specific workspace by id.
     *
     * @return bool
     */
    public function softDelete()
    {
        if ($this->checkReservationsForWorkspace()) {
            Session::flash('error', Translation::get('cannot_delete_workspace_if_there_are_reservations'));
            return false;
        }

        $softDeleted = DB::table('workspace')
            ->softDelete('workspace_is_deleted')
            ->where('workspace_ID', '=', $this->id)
            ->execute()
            ->isSuccessful();

        if ($softDeleted && empty($this->get())) {
            Session::flash('success', Translation::get('workspace_successful_deleted'));
            return true;
        }

        Session::flash('error', Translation::get('workspace_unsuccessful_deleted'));
        return false;
    }

    /**
     * Check if there are reservations for this workspace
     *
     * @return bool
     */
    private function checkReservationsForWorkspace()
    {
        $date = new Chronos();
        $reservationsForWorkspace = DB::table('workspace_reservation')
            ->select('workspace_reservation_ID')
            ->where('workspace_reservation_start_datetime', '>=', $date->toDateTimeString())
            ->where('workspace_reservation_workspace_ID', '=', $this->id)
            ->where('workspace_reservation_is_deleted', '=', 0)
            ->limit(1)
            ->execute()
            ->first();

        if (!empty($reservationsForWorkspace)) {
            return true;
        }

        return false;
    }

    /**
     * Set the workspace id.
     *
     * @param int $id The id of the workspace.
     */
    public function setID(int $id)
    {
        $this->id = $id;
    }

    /**
     * Set the slug id.
     *
     * @param int $id The id of the slug.
     */
    public function setSlugID(int $id)
    {
        $this->slugID = $id;
    }
}
