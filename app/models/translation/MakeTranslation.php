<?php


namespace App\model\translation;

use App\contracts\models\EditModel;
use App\services\core\Request;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\session\Session;

class MakeTranslation implements EditModel
{
    /**
     * The translation name.
     *
     * @var string
     */
    private $_name;

    /**
     * The translation value.
     *
     * @var string
     */
    private $_value;

    /**
     * Construct the translations.
     */
    public function __construct()
    {
        $request = new Request();

        $this->_name = str_replace(' ', '_', $request->post('name'));
        $this->_value = $request->post('value');
    }

    /**
     * Make a new translation.
     *
     * @return bool
     */
    public function execute()
    {
        if ($this->validate()) {
            $inserted = DB::table('translation')
                ->insert(
                    [
                        'translation_name' => $this->_name,
                        'translation_value' => $this->_value
                    ]
                )
                ->execute()
                ->isSuccessful();

            if ($inserted) {
                Session::flash('success', Translation::get('admin_updated_translations_successful_message'));
                return true;
            }

            Session::flash('error', Translation::get('admin_updated_translations_failed_message'));
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
        if (empty($this->_name) || empty($this->_value)) {
            Session::flash('error', Translation::get('form_message_for_required_fields'));
            return false;
        }

        if (!is_string($this->_name) || !is_string($this->_value)) {
            Session::flash('error', Translation::get('form_invalid_data'));
            return false;
        }

        if (!empty(\App\model\translation\Translation::get($this->_name))) {
            Session::flash('error', Translation::get('translation_already_exists'));
            return false;
        }

        return true;
    }
}
