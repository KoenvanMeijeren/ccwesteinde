<?php


namespace App\contracts\controllers;

use App\services\core\View;

interface HttpControllerInterface
{
    /**
     * Show the index page.
     *
     * @return View
     */
    public function index();

    /**
     * The page to be showed.
     *
     * @return View
     */
    public function pageNotFound();
}
