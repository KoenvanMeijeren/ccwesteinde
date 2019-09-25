<?php


namespace App\contracts\models\settings;

interface SettingsModelInterface
{
    /**
     * Construct the settings.
     */
    public function __construct();

    /**
     * Get a specific setting which is stored in the settings.
     *
     * @param string $key The key which will be used to search
     *                    for the corresponding value in the array.
     *
     * @return string
     */
    public function get(string $key);
}
