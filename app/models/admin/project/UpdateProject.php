<?php


namespace App\model\admin\project;

use App\contracts\models\EditModel;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\session\Session;

class UpdateProject extends Project implements EditModel
{
    /**
     * The parameters
     *
     * @var array
     */
    private $parameters;

    /**
     * Execute the updating of the project.
     *
     * @return bool
     */
    public function execute()
    {
        if ($this->prepare()) {
            $updated = DB::table('project')
                ->update($this->parameters)
                ->where('project_ID', '=', $this->id)
                ->execute()
                ->isSuccessful();

            if ($updated) {
                Session::flash('success', Translation::get('project_successfully_updated'));
                return true;
            }

            Session::flash('error', Translation::get('project_unsuccessfully_updated'));
        }

        return false;
    }

    /**
     * Prepare the updating of the project.
     *
     * @return bool
     */
    private function prepare()
    {
        if ($this->validate()) {
            if (!empty($this->thumbnailID)) {
                $this->parameters['project_thumbnail_ID'] = intval($this->thumbnailID);
            }

            if (!empty($this->bannerID)) {
                $this->parameters['project_banner_ID'] = intval($this->bannerID);
            }

            if (!empty($this->headerID)) {
                $this->parameters['project_header_ID'] = intval($this->headerID);
            }

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

        return true;
    }
}
