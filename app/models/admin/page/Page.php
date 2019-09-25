<?php


namespace App\model\admin\page;

use App\contracts\models\Model;
use App\services\core\Request;
use App\services\core\Router;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\session\Session;

class Page implements Model
{
    /**
     * Page not in menu
     *
     * @var int
     */
    const PAGE_NOT_IN_MENU = 0;

    /**
     * Page public in menu
     *
     * @var int
     */
    const PAGE_PUBLIC_IN_MENU = 1;

    /**
     * Page logged in in menu
     *
     * @var int
     */
    const PAGE_LOGGED_IN_IN_MENU = 2;

    /**
     * Static page
     *
     * @var int
     */
    const PAGE_STATIC = 3;

    /**
     * Page in footer
     *
     * @var int
     */
    const PAGE_IN_FOOTER = 4;

    /**
     * Page in menu and in footer
     *
     * @var int
     */
    const PAGE_IN_MENU_AND_IN_FOOTER = 5;

    /**
     * The id of the page.
     *
     * @var int
     */
    protected $id = 0;

    /**
     * The slug object.
     *
     * @var Slug
     */
    public $slug;

    /**
     * The page title.
     *
     * @var string
     */
    protected $title = '';

    /**
     * Will the page be showed in the menu.
     *
     * @var int
     */
    public $inMenu = 0;

    /**
     * The content of the page.
     *
     * @var string
     */
    protected $content = '';

    /**
     * Construct the page.
     *
     * @param string $slug The slug name
     */
    public function __construct(string $slug = '')
    {
        $request = new Request();

        $this->id = intval(Router::getWildcard());
        $this->title = $request->post('title');
        $this->content = $request->post('content');
        $this->inMenu = intval($request->post('inMenu'));

        // set a default slug
        $this->slug = new Slug(0, $slug);

        // if a slug is posted, set this slug for using in the page model
        if (!empty($request->post('slug'))) {
            $this->slug = new Slug(0, $request->post('slug'), true);
        }
    }

    /**
     * Get the page object.
     *
     * @return object.
     */
    public function get()
    {
        $page = DB::table('page', 1)
            ->select(
                'page.page_ID',
                'page.page_slug_ID',
                'slug.slug_name AS page_slug_name',
                'page.page_title',
                'page.page_content',
                'page.page_in_menu'
            )
            ->innerJoin('slug', 'page.page_slug_ID', 'slug.slug_ID')
            ->where('page_ID', '=', $this->id)
            ->where('page_is_deleted', '=', 0)
            ->where('slug_is_deleted', '=', 0)
            ->execute()
            ->first();

        return $page;
    }

    /**
     * Get page by slug.
     *
     * @return object
     */
    public function getBySlug()
    {
        $page = DB::table('page', 1)
            ->select(
                'page.page_ID',
                'page.page_slug_ID',
                'slug.slug_name AS page_slug_name',
                'page.page_title',
                'page.page_content',
                'page.page_in_menu'
            )
            ->innerJoin('slug', 'page.page_slug_ID', 'slug.slug_ID')
            ->where('page_slug_id', '=', $this->slug->id)
            ->where('page_is_deleted', '=', 0)
            ->where('slug_is_deleted', '=', 0)
            ->execute()
            ->first();

        return $page;
    }

    /**
     * Get all pages.
     *
     * @return array
     */
    public function getAll()
    {
        $pages = DB::table('page')
            ->select(
                'page.page_ID',
                'page.page_slug_ID',
                'slug.slug_name AS page_slug_name',
                'page.page_title',
                'page.page_content',
                'page.page_in_menu'
            )
            ->innerJoin('slug', 'page.page_slug_ID', 'slug.slug_ID')
            ->where('page_is_deleted', '=', 0)
            ->where('slug_is_deleted', '=', 0)
            ->orderBy('DESC', 'page.page_ID')
            ->execute()
            ->toArray();

        return $pages;
    }

    /**
     * Get all pages by slug.
     *
     * @return array
     */
    public function getAllBySlug()
    {
        $pages = DB::table('page')
            ->select('page.page_ID')
            ->where('page_slug_id', '=', $this->slug->id)
            ->where('page_is_deleted', '=', 0)
            ->execute()
            ->all();

        return $pages;
    }

    /**
     * Get all pages.
     *
     * @param int $inMenu The number for the pages that are in menu
     *
     * @return array
     */
    public function getAllByInMenu(int $inMenu = 1)
    {
        $pages = DB::table('page')
            ->select(
                'page.page_ID',
                'page.page_slug_ID',
                'slug.slug_name AS page_slug_name',
                'page.page_title',
                'page.page_content',
                'page.page_in_menu'
            )
            ->innerJoin('slug', 'page.page_slug_ID', 'slug.slug_ID')
            ->where('page_is_deleted', '=', 0)
            ->where('page_in_menu', '=', $inMenu)
            ->where('slug_is_deleted', '=', 0)
            ->execute()
            ->toArray();

        return $pages;
    }

    /**
     * Soft delete the page.
     *
     * @return bool
     */
    public function softDelete()
    {
        if (intval($this->get()->page_in_menu ?? 0) !== Page::PAGE_STATIC) {
            $isDeleted = DB::table('page')
                ->softDelete('page_is_deleted', 1)
                ->where('page_ID', '=', $this->id)
                ->execute()
                ->isSuccessful();

            if ($isDeleted && empty($this->get())) {
                Session::flash('success', Translation::get('page_successfully_deleted'));
                return true;
            }
        }

        Session::flash('error', Translation::get('page_unsuccessfully_deleted'));
        return false;
    }
}
