<?php


namespace App\model\admin\settings;

use App\contracts\models\settings\SettingsModelInterface;
use App\services\core\Sanitize;
use App\services\database\DB;

class Settings implements SettingsModelInterface
{
    /**
     * The settings from the database.
     *
     * @var array
     */
    private $_settings;

    /**
     * Construct the settings.
     */
    public function __construct()
    {
        $this->_settings = DB::table('setting')
            ->select('*')
            ->where('setting_is_deleted', '=', 0)
            ->execute()
            ->toArray();
    }


    /**
     * Get a specific setting which is stored in the settings.
     *
     * @param string $key The key which will be used to search
     *                    for the corresponding value in the array.
     *
     * @return string
     */
    public function get(string $key)
    {
        foreach ($this->_settings as $setting) {
            if (isset($setting['setting_key'])
                && $key === $setting['setting_key']
                && is_scalar($setting['setting_value'])
            ) {
                $sanitize = new Sanitize($setting['setting_value'] ?? '');
                return htmlspecialchars_decode($sanitize->data());
            }
        }

        return null;
    }
}
