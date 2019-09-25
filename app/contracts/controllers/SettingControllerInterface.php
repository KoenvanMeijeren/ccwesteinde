<?php


namespace App\contracts\controllers;

use App\services\core\View;
use App\services\response\RedirectResponse;

interface SettingControllerInterface
{
    /**
     * Overview of all the pages.
     *
     * @return View
     */
    public function index();

    /**
     * Proceed the user call from the method create and store it.
     *
     * @return RedirectResponse
     */
    public function store();
}
