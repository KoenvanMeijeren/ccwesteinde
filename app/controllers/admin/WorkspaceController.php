<?php


namespace App\controllers\admin;

use App\contracts\controllers\ShortCRUDControllerInterface;
use App\model\admin\workspace\MakeWorkspace;
use App\model\admin\workspace\UpdateWorkspace;
use App\model\admin\workspace\Workspace;
use App\services\core\Translation;
use App\services\core\View;
use App\services\response\RedirectResponse;
use App\services\security\CSRF;
use App\services\session\Session;

class WorkspaceController implements ShortCRUDControllerInterface
{
    /**
     * The workspace object
     *
     * @var Workspace
     */
    private $workspace;

    /**
     * Construct the workspace
     */
    public function __construct()
    {
        $this->workspace = new Workspace();
    }

    /**
     * Overview of all the items.
     *
     * @return View
     */
    public function index()
    {
        $title = Translation::get('admin_workspace_maintenance_title');
        $workspaces = $this->workspace->getAll();
        $workspace = $this->workspace->get();

        return new View('admin/workspace/index', compact('title', 'workspaces', 'workspace'));
    }

    /**
     * Proceed the user call from the method create and store it.
     *
     * @return RedirectResponse|View
     */
    public function store()
    {
        $makeWorkspace = new MakeWorkspace();
        if (CSRF::validate() && $makeWorkspace->execute()) {
            Session::flash('success', Translation::get('workspace_successfully_created'));
            return new RedirectResponse('/admin/workspace');
        }

        return $this->index();
    }

    /**
     * Update a specific item.
     *
     * @return RedirectResponse|View
     */
    public function update()
    {
        $updateWorkspace = new UpdateWorkspace();
        if (CSRF::validate() && $updateWorkspace->execute()) {
            Session::flash('success', Translation::get('workspace_successfully_updated'));
            return new RedirectResponse('/admin/workspace');
        }

        return $this->index();
    }

    /**
     * Soft delete a specific item.
     *
     * @return RedirectResponse
     */
    public function destroy()
    {
        $this->workspace->softDelete();

        return new RedirectResponse('/admin/workspace');
    }
}
