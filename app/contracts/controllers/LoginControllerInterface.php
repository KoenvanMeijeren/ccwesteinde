<?php

namespace App\contracts\controllers;

use App\services\core\View;
use App\services\response\RedirectResponse;

interface LoginControllerInterface
{
    /**
     * Overview of all the items.
     *
     * @return View
     */
    public function index();

    /**
     * Proceed the user call from the method index and try to log the user in.
     *
     * @return RedirectResponse
     */
    public function login();

    /**
     * Log the user out.
     *
     * @return RedirectResponse
     */
    public function logout();
}
