<?php


namespace App\controllers\admin;

use App\contracts\controllers\SettingControllerInterface;
use App\model\admin\settings\Settings;
use App\model\admin\settings\UpdateSettings;
use App\services\core\Translation;
use App\services\core\View;
use App\services\response\RedirectResponse;
use App\services\security\CSRF;
use App\services\session\Session;

class SettingsController implements SettingControllerInterface
{
    /**
     * Show the form to edit the settings.
     *
     * @return View
     */
    public function index()
    {
        $title = Translation::get('admin_settings_title');

        return new View('admin/settings/settings', compact('title'));
    }

    /**
     * Proceed the user call and store or update it in the database.
     *
     * @return RedirectResponse|View
     */
    public function store()
    {
        $settings = new UpdateSettings(new Settings());
        if (CSRF::validate() && $settings->makeOrUpdateSettings()) {
            return new RedirectResponse('/admin/settings');
        }

        return $this->index();
    }
}
