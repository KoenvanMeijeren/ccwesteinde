<?php


namespace App\model\admin\project;

use App\contracts\models\EditModel;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\session\Session;

class MakeProject extends Project implements EditModel
{
    /**
     * The parameters
     *
     * @var array
     */
    private $parameters;

    /**
     * Execute the making of the project.
     *
     * @return bool
     */
    public function execute()
    {
        if ($this->prepare()) {
            $lastInsertedId = DB::table('project')
                ->insert($this->parameters)
                ->execute()
                ->getLastInsertedId();
            $this->id = $lastInsertedId;

            if (!empty($this->get())) {
                Session::flash('success', Translation::get('project_successfully_created'));
                return true;
            }

            Session::flash('error', Translation::get('project_unsuccessfully_created'));
        }

        return false;
    }

    /**
     * Prepare the making of the project.
     *
     * @return bool
     */
    private function prepare()
    {
        if ($this->validate()) {
            $this->parameters['project_thumbnail_ID'] = intval($this->thumbnailID);
            $this->parameters['project_banner_ID'] = intval($this->bannerID);
            $this->parameters['project_header_ID'] = intval($this->headerID);
            $this->parameters['project_title'] = $this->title;
            $this->parameters['project_content'] = $this->content;

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
            || empty($this->content)
        ) {
            Session::flash('error', Translation::get('form_message_for_required_fields'));
            return false;
        }

        if (empty($this->thumbnailID)
            || empty($this->headerID)
            || empty($this->bannerID)
        ) {
            return false;
        }

        return true;
    }
}
