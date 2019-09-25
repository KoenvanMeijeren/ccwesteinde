<?php


namespace App\model\admin\page;

use App\contracts\models\EditModel;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\session\Session;

class MakePage extends Page implements EditModel
{
    /**
     * The parameters
     *
     * @var array
     */
    private $parameters;

    /**
     * Execute the making of the page.
     *
     * @return bool
     */
    public function execute()
    {
        if ($this->prepare()) {
            $lastInsertedId = DB::table('page')
                ->insert($this->parameters)
                ->execute()
                ->getLastInsertedId();
            $this->id = $lastInsertedId;

            if (!empty($this->get())) {
                Session::flash('success', Translation::get('page_successfully_created'));
                return true;
            }

            Session::flash('error', Translation::get('page_unsuccessfully_created'));
        }

        return false;
    }

    /**
     * Prepare the making of the page.
     *
     * @return bool
     */
    private function prepare()
    {
        if ($this->validate()) {
            $this->parameters['page_slug_ID'] = intval($this->slug->id);
            $this->parameters['page_title'] = $this->title;
            $this->parameters['page_content'] = $this->content;
            $this->parameters['page_in_menu'] = intval($this->inMenu);

            return true;
        }

        return false;
    }

    /**
     * Validate the input
     *
     * @return bool
     */
    private function validate()
    {
        if (!empty($this->slug->name)) {
            if (!preg_match('/^[a-zA-Z-]*$/', $this->slug->name)) {
                Session::flash('error', Translation::get('form_invalid_date'));
                return false;
            }
        }

        if (empty($this->title)
            || empty($this->slug->id)
            || empty($this->slug->name)
        ) {
            Session::flash('error', Translation::get('form_message_for_required_fields'));
            return false;
        }

        if ($this->inMenu !== Page::PAGE_NOT_IN_MENU &&
            $this->inMenu !== Page::PAGE_LOGGED_IN_IN_MENU &&
            $this->inMenu !== Page::PAGE_STATIC &&
            $this->inMenu !== Page::PAGE_IN_FOOTER &&
            $this->inMenu !== Page::PAGE_IN_MENU_AND_IN_FOOTER) {
            Session::flash('error', Translation::get('form_invalid_data'));
            return false;
        }

        return true;
    }
}
