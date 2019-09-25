<?php


namespace App\contracts\controllers;

use App\services\core\View;
use App\services\response\RedirectResponse;

interface AccountControllerInterface
{
    /**
     * Overview of the account.
     *
     * @return View
     */
    public function index();

    /**
     * Proceed the user call from the method index and update the account.
     *
     * @return RedirectResponse
     */
    public function update();
}
