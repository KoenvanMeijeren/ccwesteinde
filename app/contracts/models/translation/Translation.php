<?php


namespace App\contracts\models\translation;


interface Translation
{
    /**
     * Get a specific translation which is stored in the translations.
     *
     * @param string $key The key which will be used to search
     *                    for the corresponding value in the array.
     *
     * @return string
     */
    public static function get(string $key);

    /**
     * Get all the translations.
     *
     * @return array
     */
    public static function getAll();
}