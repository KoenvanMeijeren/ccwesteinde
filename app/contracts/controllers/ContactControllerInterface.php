<?php

namespace App\contracts\controllers;

use App\services\core\View;
use App\services\response\RedirectResponse;

interface ContactControllerInterface
{
    /**
     * Overview of all the items.
     *
     * @return View
     */
    public function index();

    /**
     * Proceed the user call from the method index and send the contact form.
     *
     * @return RedirectResponse
     */
    public function contact();

    /**
     * Show the contact form sent page.
     *
     * @return View
     */
    public function sent();
}
