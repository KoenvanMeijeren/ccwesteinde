<?php


namespace App\contracts\controllers;

use App\services\core\View;
use App\services\response\RedirectResponse;

interface OverviewAndSpecificControllerInterface
{
    /**
     * Show the overview of items page.
     *
     * @return View
     */
    public function index();

    /**
     * Show one specific item page.
     *
     * @return View|RedirectResponse
     */
    public function show();
}
