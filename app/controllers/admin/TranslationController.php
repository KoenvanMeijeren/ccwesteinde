<?php


namespace App\controllers\admin;

use App\contracts\controllers\SettingControllerInterface;
use App\model\translation\MakeTranslation;
use App\model\translation\UpdateTranslations;
use App\services\core\Translation;
use App\services\core\View;
use App\services\response\RedirectResponse;
use App\services\security\CSRF;

class TranslationController implements SettingControllerInterface
{
    /**
     * Show the form to edit the translations.
     *
     * @return View
     */
    public function index()
    {
        $title = Translation::get('admin_translations_title');
        $translations = \App\model\translation\Translation::getAll();

        return new View('admin/translation/index', compact('title', 'translations'));
    }

    /**
     * Proceed the user call and store or update it in the database.
     *
     * @return RedirectResponse|View
     */
    public function store()
    {
        $translation = new MakeTranslation();
        if (CSRF::validate() && $translation->execute()) {
            return new RedirectResponse('/admin/translations');
        }

        return $this->index();
    }

    /**
     * Proceed the user call and store or update it in the database.
     *
     * @return RedirectResponse|View
     */
    public function update()
    {
        $translation = new UpdateTranslations();
        if (CSRF::validate() && $translation->execute()) {
            return new RedirectResponse('/admin/translations');
        }

        return $this->index();
    }
}
