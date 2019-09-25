<?php


namespace App\services\helpers;

use App\model\admin\accounts\Account;
use App\model\admin\page\Page;
use App\services\core\Translation;

class Convert
{
    /**
     * Convert the given rights into a string
     *
     * @param int $rights The rights to be converted in a string.
     *
     * @return string
     */
    public static function rights(int $rights)
    {
        switch ($rights) {
        case Account::ACCOUNT_RIGHTS_LEVEL_1:
            return Translation::get('form_rights_level_1');
                break;

        case Account::ACCOUNT_RIGHTS_LEVEL_2:
            return Translation::get('form_rights_level_2');
                break;

        case Account::ACCOUNT_RIGHTS_LEVEL_3:
            return Translation::get('form_rights_level_3');
                break;

        case Account::ACCOUNT_RIGHTS_LEVEL_4:
            return Translation::get('form_rights_level_4');
                break;

        default:
            return Translation::get('form_rights_unknown');
                break;
        }
    }

    /**
     * Convert the page in menu value to a string.
     *
     * @param int $pageInMenu The int to be converted.
     *
     * @return string
     */
    public static function pageInMenu(int $pageInMenu)
    {
        switch ($pageInMenu) {
        case Page::PAGE_IN_MENU_AND_IN_FOOTER:
            return Translation::get('form_yes_and_in_footer');
                break;
        case Page::PAGE_IN_FOOTER:
            return Translation::get('form_yes_in_footer');
                break;
        case Page::PAGE_STATIC:
            return Translation::get('form_static');
                break;
        case Page::PAGE_LOGGED_IN_IN_MENU:
            return Translation::get('form_yes_loggedIn');
                break;
        case Page::PAGE_PUBLIC_IN_MENU:
            return Translation::get('form_yes_public');
                break;
        case Page::PAGE_NOT_IN_MENU:
            return Translation::get('form_no');
                break;
        default:
            return Translation::get('form_unknown');
                break;
        }
    }
}
