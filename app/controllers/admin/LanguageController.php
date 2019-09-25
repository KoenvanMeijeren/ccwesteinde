<?php


namespace App\controllers\admin;

use App\contracts\controllers\LanguageControllerInterface;
use App\services\core\URL;
use App\services\response\RedirectResponse;
use App\services\session\Session;

class LanguageController implements LanguageControllerInterface
{
    /**
     * Set the dutch language to use in the application.
     *
     * @return RedirectResponse
     */
    public function dutch()
    {
        if (isset($_SESSION['languageID'])) {
            unset($_SESSION['languageID']);
        }

        Session::save('languageID', 1);
        return new RedirectResponse('/' . URL::getPreviousUrl());
    }

    /**
     * Set the english language to use in the application.
     *
     * @return RedirectResponse
     */
    public function english()
    {
        if (isset($_SESSION['languageID'])) {
            unset($_SESSION['languageID']);
        }

        Session::save('languageID', 2);
        return new RedirectResponse('/' . URL::getPreviousUrl());
    }
}
