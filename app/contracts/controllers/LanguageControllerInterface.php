<?php


namespace App\contracts\controllers;

use App\services\response\RedirectResponse;

interface LanguageControllerInterface
{
    /**
     * Set the dutch language for the application.
     *
     * @return RedirectResponse
     */
    public function dutch();

    /**
     * Set the english language for the application.
     *
     * @return RedirectResponse
     */
    public function english();
}
