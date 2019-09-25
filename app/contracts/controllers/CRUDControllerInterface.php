<?php

namespace App\contracts\controllers;

use App\services\core\View;
use App\services\response\RedirectResponse;

interface CRUDControllerInterface
{
    /**
     * Overview of all the items.
     *
     * @return View
     */
    public function index();

    /**
     * Show the form to create a new item.
     *
     * @return View
     */
    public function create();

    /**
     * Proceed the user call from the method create and store it.
     *
     * @return RedirectResponse
     */
    public function store();


    /**
     * Show the form to edit a specific item.
     *
     * @return View
     */
    public function edit();

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
