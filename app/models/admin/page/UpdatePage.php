<?php


namespace App\model\admin\page;

use App\contracts\models\EditModel;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\session\Session;

class UpdatePage extends Page implements EditModel
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
            $updated = DB::table('page')
                ->update($this->parameters)
                ->where('page_ID', '=', $this->id)
                ->execute()
                ->isSuccessful();

            if ($updated) {
                Session::flash('success', Translation::get('page_successfully_updated'));
                return true;
            }

            Session::flash('error', Translation::get('page_unsuccessfully_updated'));
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

            if (!empty($this->inMenu)) {
                $this->parameters['page_in_menu'] = intval($this->inMenu);
            }

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
        if (empty($this->title)
            || empty($this->slug->id)
            || empty($this->slug->name)
        ) {
            Session::flash('error', Translation::get('form_message_for_required_fields'));
            return false;
        }

        return true;
    }
}
