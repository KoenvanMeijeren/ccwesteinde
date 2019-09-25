<?php


namespace App\model\admin\workspace;

use App\contracts\models\EditModel;
use App\model\admin\page\Slug;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\session\Session;

class MakeWorkspace extends Workspace implements EditModel
{
    /**
     * The parameters to be inserted.
     *
     * @var array
     */
    private $parameters;

    /**
     * Construct the workspace.
     */
    public function __construct()
    {
        parent::__construct();

        $slug = new Slug(0, $this->slug, true);
        $this->slugID = $slug->id;
    }

    /**
     * Execute the making of the workspace.
     */
    public function execute()
    {
        if ($this->prepare()) {
            $inserted = DB::table('workspace')
                ->insert($this->parameters)
                ->execute()
                ->isSuccessful();

            return $inserted;
        }

        return false;
    }

    /**
     * Prepare the making of the workspace.
     *
     * @return bool
     */
    private function prepare()
    {
        if ($this->validate()) {
            $this->parameters['workspace_slug_ID'] = $this->slugID;
            $this->parameters['workspace_name'] = $this->name;

            return true;
        }

        return false;
    }

    /**
     * Validate the input.
     *
     * @return bool
     */
    private function validate()
    {
        if (empty($this->name)) {
            Session::flash('error', Translation::get('form_message_for_required_fields'));
            return false;
        }

        if (!is_string($this->name)) {
            Session::flash('error', Translation::get('form_invalid_date'));
            return false;
        }

        if (!empty($this->getByName())) {
            Session::flash('error', Translation::get('form_name_already_exists'));
            return false;
        }

        return true;
    }
}
