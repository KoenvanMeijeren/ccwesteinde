<?php


namespace App\controllers;

use App\contracts\controllers\OverviewAndSpecificControllerInterface;
use App\model\admin\page\Page;
use App\model\admin\project\Project;
use App\services\core\Translation;
use App\services\core\View;
use App\services\response\RedirectResponse;
use App\services\session\Session;

class ProjectController implements OverviewAndSpecificControllerInterface
{
    /**
     * The project object.
     *
     * @var Project
     */
    private $project;

    /**
     * Construct the project
     */
    public function __construct()
    {
        $this->project = new Project();
    }

    /**
     * Show the overview of projects page.
     *
     * @return View
     */
    public function index()
    {
        $page = new Page('projecten');

        $page = $page->getBySlug();
        $title = $page->page_title ?? Translation::get('project_page_title');
        $projects = $this->project->getAll();

        return new View('projects/index', compact('title', 'page', 'projects'));
    }

    /**
     * Show one specific project page.
     *
     * @return View|RedirectResponse
     */
    public function show()
    {
        $project = $this->project->get();

        if (!empty($project)) {
            $title = $project->project_title ?? Translation::get('project_page_title');

            return new View('projects/project', compact('title', 'project'));
        }

        Session::flash('error', Translation::get('project_cannot_be_visited'));
        return new RedirectResponse('/projecten');
    }
}
