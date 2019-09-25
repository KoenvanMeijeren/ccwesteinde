<?php


namespace App\controllers\admin;

use App\contracts\controllers\CRUDControllerInterface;
use App\model\admin\project\MakeProject;
use App\model\admin\project\Project;
use App\model\admin\project\UpdateProject;
use App\services\core\Translation;
use App\services\core\View;
use App\services\response\RedirectResponse;

class ProjectController implements CRUDControllerInterface
{
    /**
     * The project object.
     *
     * @var Project
     */
    private $project;

    /**
     * Construct the project controller.
     */
    public function __construct()
    {
        $this->project = new Project();
    }

    /**
     * Overview of all the projects.
     *
     * @return View
     */
    public function index()
    {
        $title = Translation::get('admin_projects_maintenance_title');
        $projects = $this->project->getAll();

        return new View('/admin/project/index', compact('title', 'projects'));
    }

    /**
     * Show the page to create a new project
     *
     * @return View
     */
    public function create()
    {
        $title = Translation::get('admin_create_project_title');

        return new View('/admin/project/edit', compact('title'));
    }

    /**
     * Proceed the user call from the method create and store it.
     *
     * @return RedirectResponse|View
     */
    public function store()
    {
        $makeProject = new MakeProject();
        if ($makeProject->execute()) {
            return new RedirectResponse('/admin/projects');
        }

        return $this->create();
    }

    /**
     * Show the page to edit a specific project.
     *
     * @return View
     */
    public function edit()
    {
        $title = Translation::get('admin_edit_project_title');
        $project = $this->project->get();

        return new View('/admin/project/edit', compact('title', 'project'));
    }

    /**
     * Proceed the user call from the method update and update it.
     *
     * @return View|RedirectResponse
     */
    public function update()
    {
        $updateProject = new UpdateProject();
        if ($updateProject->execute()) {
            return new RedirectResponse('/admin/projects');
        }

        return $this->edit();
    }


    /**
     * Soft delete a project by id.
     *
     * @return RedirectResponse
     */
    public function destroy()
    {
        $this->project->softDelete();

        return new RedirectResponse('/admin/projects');
    }
}
