<?php


namespace App\contracts\models\settings;

use App\model\admin\settings\Settings;

interface UpdateSettingsModelInterface
{
    /**
     * Construct the settings.
     *
     * @param Settings $settings
     */
    public function __construct(Settings $settings);

    /**
     * Make or update the settings.
     *
     * @return bool
     */
    public function makeOrUpdateSettings();
}
