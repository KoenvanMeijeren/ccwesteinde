<?php


namespace App\controllers;

use App\contracts\controllers\HttpControllerInterface;
use App\model\admin\account\User;
use App\model\admin\accounts\Account;
use App\model\admin\page\Page;
use App\model\admin\project\Project;
use App\services\core\Cookie;
use App\services\core\Translation;
use App\services\core\URL;
use App\services\core\View;
use App\services\response\RedirectResponse;
use App\services\session\Session;

class PageController implements HttpControllerInterface
{
    /**
     * Show the index page.
     *
     * @return View
     */
    public function index()
    {
        $page = new Page('home');
        $project = new Project();

        $page = $page->getBySlug();
        $projects = $project->getFirstThree();
        $title = $page->page_title ?? Translation::get('home_page_title');

        return new View('home/index', compact('title', 'page', 'projects'));
    }

    /**
     * Show the company page.
     *
     * @return View
     */
    public function company()
    {
        $page = new Page('bedrijf');

        $page = $page->getBySlug();
        $title = $page->page_title ?? Translation::get('company_page_title');

        return new View('company/index', compact('title', 'page'));
    }

    /**
     * Show the student page.
     *
     * @return View
     */
    public function student()
    {
        $page = new Page('student');

        $page = $page->getBySlug();
        $title = $page->page_title ?? Translation::get('student_page_title');

        return new View('student/index', compact('title', 'page'));
    }

    /**
     * Try to show dynamically a page stored in the database.
     * Otherwise show the page not found.
     *
     * @return View|RedirectResponse
     */
    public function pageNotFound()
    {
        $page = new Page(URL::getUrl());
        $user = new User();

        $page = $page->getBySlug();

        // if the page is only visible when the user is logged in
        // and the user rights are not high enough, show the not found view
        if (intval($page->page_in_menu ?? 0) === Page::PAGE_LOGGED_IN_IN_MENU &&
            $user->getRights() === Account::ACCOUNT_RIGHTS_LEVEL_0) {
            return $this->notFoundView();
        }

        if (!empty($page)) {
            $title = $page->page_title ?? '';

            return new View('template/index', compact('title', 'page'));
        }

        if (URL::getUrl() === 'werkplek/reserveren' || URL::getUrl() === 'meet-the-expert-events') {
            Session::save('path', URL::getUrl());
            return new RedirectResponse('/inloggen');
        }

        return $this->notFoundView();
    }

    /**
     * Show the not found page.
     *
     * @return View
     */
    private function notFoundView()
    {
        $page = new Page('pagina-niet-gevonden');

        $page = $page->getBySlug();
        $title = $page->page_title ?? Translation::get('page_not_found_title');

        return new View('errors/404', compact('title', 'page'));
    }
}
