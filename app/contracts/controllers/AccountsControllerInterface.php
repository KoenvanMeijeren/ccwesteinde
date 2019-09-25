<?php

namespace App\contracts\controllers;

use App\services\core\View;
use App\services\response\RedirectResponse;

interface AccountsControllerInterface
{
    /**
     * Overview of all the accounts.
     *
     * @return View
     */
    public function index();

    /**
     * Show the form to create a new account.
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
     * Show the form to edit a specific account.
     *
     * @return View|RedirectResponse
     */
    public function edit();

    /**
     * Update a specific account.
     *
     * @return RedirectResponse
     */
    public function update();

    /**
     * Unblock a specific account.
     *
     * @return RedirectResponse
     */
    public function unblock();

    /**
     * Soft delete a specific account.
     *
     * @return RedirectResponse
     */
    public function destroy();
}
