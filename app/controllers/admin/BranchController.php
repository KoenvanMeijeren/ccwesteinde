<?php


namespace App\controllers\admin;

use App\contracts\controllers\ShortCRUDControllerInterface;
use App\model\admin\branch\Branch;
use App\model\admin\branch\MakeBranch;
use App\model\admin\branch\UpdateBranch;
use App\services\core\Translation;
use App\services\core\View;
use App\services\response\RedirectResponse;
use App\services\security\CSRF;
use App\services\session\Session;

class BranchController implements ShortCRUDControllerInterface
{
    /**
     * The branch object
     *
     * @var Branch
     */
    private $branch;

    /**
     * Construct the branch
     */
    public function __construct()
    {
        $this->branch = new Branch();
    }

    /**
     * Overview of all the items.
     *
     * @return View
     */
    public function index()
    {
        $title = Translation::get('admin_branch_maintenance_title');
        $branches = $this->branch->getAll();
        $branch = $this->branch->get();

        return new View('admin/branch/index', compact('title', 'branches', 'branch'));
    }

    /**
     * Proceed the user call from the method create and store it.
     *
     * @return RedirectResponse|View
     */
    public function store()
    {
        $makeBranch = new MakeBranch();
        if (CSRF::validate() && $makeBranch->execute()) {
            Session::flash('success', Translation::get('branch_successfully_created'));
            return new RedirectResponse('/admin/branch');
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
        $updateBranch = new UpdateBranch();
        if (CSRF::validate() && $updateBranch->execute()) {
            Session::flash('success', Translation::get('branch_successfully_updated'));
            return new RedirectResponse('/admin/branch');
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
        $this->branch->softDelete();

        return new RedirectResponse('/admin/branch');
    }
}
