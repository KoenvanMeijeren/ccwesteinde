<?php


namespace App\model\translation;

use App\services\core\Sanitize;
use App\services\database\DB;

class Translation implements \App\contracts\models\translation\Translation
{
    /**
     * The translations from the database.
     *
     * @var array
     */
    private static $translations;

    /**
     * Construct the translations.
     */
    private static function getTranslations()
    {
        self::$translations = DB::table('translation')
            ->select('*')
            ->where('translation_is_deleted', '=', 0)
            ->orderBy('DESC', 'translation_ID')
            ->execute()
            ->toArray();
    }


    /**
     * Get a specific translation which is stored in the translations.
     *
     * @param string $key The key which will be used to search
     *                    for the corresponding value in the array.
     *
     * @return string
     */
    public static function get(string $key)
    {
        self::getTranslations();

        foreach (self::$translations as $translation) {
            if (isset($translation['translation_name'])
                && $key === $translation['translation_name']
                && is_scalar($translation['translation_value'])
            ) {
                $sanitize = new Sanitize($translation['translation_value'] ?? '');
                return parseHTMLEntities($sanitize->data());
            }
        }

        return '';
    }

    /**
     * Get all the translations.
     *
     * @return array
     */
    public static function getAll()
    {
        self::getTranslations();

        return self::$translations;
    }
}
