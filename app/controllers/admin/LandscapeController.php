<?php


namespace App\controllers\admin;

use App\contracts\controllers\ShortCRUDControllerInterface;
use App\model\admin\landscape\MakeLandscape;
use App\model\admin\landscape\UpdateLandscape;
use App\model\admin\landscape\Landscape;
use App\services\core\Translation;
use App\services\core\View;
use App\services\response\RedirectResponse;
use App\services\security\CSRF;
use App\services\session\Session;

class LandscapeController implements ShortCRUDControllerInterface
{
    /**
     * The landscape object
     *
     * @var Landscape
     */
    private $landscape;

    /**
     * Construct the landscape
     */
    public function __construct()
    {
        $this->landscape = new Landscape();
    }

    /**
     * Overview of all the items.
     *
     * @return View
     */
    public function index()
    {
        $title = Translation::get('admin_landscape_maintenance_title');
        $landscapes = $this->landscape->getAll();
        $landscape = $this->landscape->get();

        return new View('admin/landscape/index', compact('title', 'landscapes', 'landscape'));
    }

    /**
     * Proceed the user call from the method create and store it.
     *
     * @return RedirectResponse|View
     */
    public function store()
    {
        $makeLandscape = new MakeLandscape();
        if (CSRF::validate() && $makeLandscape->execute()) {
            Session::flash('success', Translation::get('landscape_successfully_created'));
            return new RedirectResponse('/admin/landscape');
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
        $updateLandscape = new UpdateLandscape();
        if (CSRF::validate() && $updateLandscape->execute()) {
            Session::flash('success', Translation::get('landscape_successfully_updated'));
            return new RedirectResponse('/admin/landscape');
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
        $this->landscape->softDelete();

        return new RedirectResponse('/admin/landscape');
    }
}
