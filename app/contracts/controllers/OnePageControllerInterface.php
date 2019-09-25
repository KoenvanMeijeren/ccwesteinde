<?php


namespace App\contracts\controllers;

use App\services\core\View;

interface OnePageControllerInterface
{
    /**
     * The page to be showed.
     *
     * @return View
     */
    public function index();
}
