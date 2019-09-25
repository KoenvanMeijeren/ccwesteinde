<?php

namespace App\contracts\controllers;

use App\services\core\View;
use App\services\response\RedirectResponse;

interface ShortCRUDControllerInterface
{
    /**
     * Overview of all the items.
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

    /**
     * Update a specific item.
     *
     * @return RedirectResponse
     */
    public function update();

    /**
     * Soft delete a specific item.
     *
     * @return RedirectResponse
     */
    public function destroy();
}
