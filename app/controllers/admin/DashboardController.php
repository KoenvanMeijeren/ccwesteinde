<?php


namespace App\controllers\admin;

use App\contracts\controllers\OnePageControllerInterface;
use App\services\core\Translation;
use App\services\core\View;

class DashboardController implements OnePageControllerInterface
{
    /**
     * Overview of all the items.
     *
     * @return View
     */
    public function index()
    {
        $title = Translation::get('admin_dashboard_title');

        return new View('admin/dashboard/index', compact('title'));
    }
}
