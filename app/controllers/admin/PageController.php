<?php


namespace App\controllers\admin;

use App\contracts\controllers\CRUDControllerInterface;
use App\model\admin\page\File;
use App\model\admin\page\MakePage;
use App\model\admin\page\Page;
use App\model\admin\page\UpdatePage;
use App\services\core\Request;
use App\services\core\Translation;
use App\services\core\View;
use App\services\response\RedirectResponse;
use App\services\session\Session;

class PageController implements CRUDControllerInterface
{
    /**
     * The page.
     *
     * @var Page
     */
    private $page;

    /**
     * Construct the page.
     */
    public function __construct()
    {
        $this->page = new Page();
    }

    /**
     * Overview of all the pages.
     *
     * @return View
     */
    public function index()
    {
        $title = Translation::get('admin_pages_maintenance_title');
        $pages = $this->page->getAll();

        return new View('admin/page/index', compact('title', 'pages'));
    }

    /**
     * Create a new page.
     *
     * @return View
     */
    public function create()
    {
        $title = Translation::get('admin_pages_maintenance_title');

        return new View('admin/page/edit', compact('title'));
    }

    /**
     * Proceed the user call from the method create and store it.
     *
     * @return RedirectResponse|View
     */
    public function store()
    {
        if (empty($this->page->getBySlug())) {
            $makePage = new MakePage();
            if ($makePage->execute()) {
                return new RedirectResponse('/admin/pages');
            }

            return $this->create();
        }

        Session::flash('error', Translation::get('page_already_exists'));
        return $this->create();
    }

    /**
     * Show the form to edit a specific page.
     *
     * @return RedirectResponse|View
     */
    public function edit()
    {
        $title = Translation::get('admin_pages_maintenance_title');
        $page = $this->page->get();

        if (empty($page)) {
            Session::flash('error', Translation::get('page_could_not_be_edited'));
            return new RedirectResponse('/admin/pages');
        }

        return new View('admin/page/edit', compact('title', 'page'));
    }

    /**
     * Proceed the user call from the method edit and update it.
     *
     * @return RedirectResponse|View
     */
    public function update()
    {
        if ($this->page->get()->page_slug_name === $this->page->slug->name &&
            count($this->page->getAllBySlug()) >= Page::PAGE_LOGGED_IN_IN_MENU
        ) {
            Session::flash('error', Translation::get('page_already_exists'));
            return $this->edit();
        }

        if (intval($this->page->inMenu) === Page::PAGE_STATIC &&
            $this->page->slug->name !== $this->page->get()->page_slug_name
        ) {
            Session::flash('error', Translation::get('page_slug_cannot_be_edited'));
            return $this->edit();
        }

        if (!empty($this->page->inMenu) && intval($this->page->get()->page_in_menu ?? 0) === Page::PAGE_STATIC
            && intval($this->page->get()->page_in_menu ?? 0) !== $this->page->inMenu
        ) {
            Session::flash('error', Translation::get('page_in_menu_cannot_be_edited'));
            return $this->edit();
        }

        $updatePage = new UpdatePage();
        if ($updatePage->execute()) {
            return new RedirectResponse('/admin/pages');
        }

        return $this->edit();
    }

    /**
     * Destroy a specific page.
     *
     * @return RedirectResponse
     */
    public function destroy()
    {
        $this->page->softDelete();

        return new RedirectResponse('/admin/pages');
    }

    /**
     * Upload a file from anywhere.
     *
     * @return void
     */
    public function upload()
    {
        $request = new Request();
        $thumbnail = $request->file('thumbnailOutput');
        $banner = $request->file('bannerOutput');
        $header = $request->file('headerOutput');

        // make the thumbnail file
        if (isset($thumbnail['name']) && !empty($thumbnail['name'])) {
            $file = new File($thumbnail);
            $file = $file->getByPath();

            $path = $file->file_path ?? '';

            header('Content-Type: application/json');
            echo json_encode($path);
            exit();
        }

        // make the banner file
        if (isset($banner['name']) && !empty($banner['name'])) {
            $file = new File($banner);
            $file = $file->getByPath();

            $path = $file->file_path ?? '';

            header('Content-Type: application/json');
            echo json_encode($path);
            exit();
        }

        // make the header file
        if (isset($header['name']) && !empty($header['name'])) {
            $file = new File($header);
            $file = $file->getByPath();

            $path = $file->file_path ?? '';

            header('Content-Type: application/json');
            echo json_encode($path);
            exit();
        }
    }
}
