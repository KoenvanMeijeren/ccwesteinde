<?php


namespace App\model\translation;

use App\contracts\models\EditModel;
use App\services\core\Request;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\session\Session;

class UpdateTranslations implements EditModel
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
     * Update the settings
     *
     * @return bool
     */
    public function execute()
    {
        $request = new Request();
        $translations = \App\model\translation\Translation::getAll();

        if (!empty($translations)) {
            foreach ($translations as $translation) {
                $this->_name = $translation['translation_name'] ?? '';
                $this->_value = $request->post($this->_name);

                $this->update();
            }
        }

        Session::flash('success', Translation::get('admin_updated_translations_successful_message'));
        return true;
    }

    /**
     * Update a specific translation which is matching with the given key.
     *
     * @return void
     */
    private function update()
    {
        DB::table('translation')
            ->update(['translation_value' => $this->_value])
            ->where('translation_name', '=', $this->_name)
            ->where('translation_is_deleted', '=', 0)
            ->execute();

        unset($this->_name);
        unset($this->_value);
    }
}
