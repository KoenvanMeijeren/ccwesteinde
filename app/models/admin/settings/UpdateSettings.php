<?php


namespace App\model\admin\settings;

use App\contracts\models\settings\UpdateSettingsModelInterface;
use App\model\admin\page\File;
use App\services\core\Request;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\session\Session;

class UpdateSettings implements UpdateSettingsModelInterface
{
    /**
     * The settings.
     *
     * @var Settings
     */
    private $_settings;

    /**
     * The input settings array.
     *
     * @var array
     */
    private $_parameters;

    /**
     * Construct the settings.
     *
     * @param Settings $settings
     */
    public function __construct(Settings $settings)
    {
        $this->_settings = $settings;
        $request = new Request();
        $this->_parameters = $request->posts(
            [
                'companyName',
                'companyTel',
                'companyEmail',
                'companyAddress',
                'companyPostcode',
                'companyCity',
                'facebook',
                'instagram',
                'linkedin',
                'youtube',
                'twitter',
                'studentEmail',
                'teacherEmail',
                'schoolOpeningHour',
                'schoolClosingHour'
            ]
        );

        $file = $request->file('workspace_image');
        if (isset($file['name']) && !empty($file['name'])) {
            $file = new File($file);
            $this->_parameters['workspace_image'] = $file->getByPath()->file_path ?? '';
        }
    }

    /**
     * Make or update the settings.
     *
     * @return bool
     */
    public function makeOrUpdateSettings()
    {
        if ($this->validate()) {
            foreach ($this->_parameters as $key => $parameter) {
                if ($this->_settings->get($key) === null) {
                    $this->makeSetting($key, $parameter);
                    continue;
                }

                $this->updateSetting($key, $parameter);
                continue;
            }

            Session::flash('success', Translation::get('admin_updated_settings_successful_message'));
            return true;
        }

        return false;
    }

    /**
     * Make a new setting.
     *
     * @param string $key   The key of the value.
     * @param mixed  $value The value of the key.
     *
     * @return bool
     */
    private function makeSetting(string $key, $value)
    {
        $inserted = DB::table('setting')
            ->insert(
                [
                    'setting_key' => $key,
                    'setting_value' => $value
                ]
            )
            ->execute()
            ->isSuccessful();

        return $inserted;
    }

    /**
     * Update a specific setting which is matching with the given key.
     *
     * @param string $key   The key of the value.
     * @param mixed  $value The new value of the key.
     *
     * @return bool
     */
    private function updateSetting(string $key, $value)
    {
        $updated = DB::table('setting')
            ->update(
                [
                    'setting_value' => $value
                ]
            )
            ->where('setting_key', '=', $key)
            ->where('setting_is_deleted', '=', 0)
            ->execute()
            ->isSuccessful();

        return $updated;
    }

    /**
     * Validate the input
     */
    private function validate()
    {
        $request = new Request();
        foreach ($this->_parameters as $key => $parameter) {
            if ($key === 'facebook' || $key === 'instagram' || $key === 'linkedIn' || $key = 'youtube' || $key = 'twitter') {
                continue;
            }

            if (empty($parameter)) {
                Session::flash('error', Translation::get('form_message_for_required_fields'));
                return false;
            }
        }

        if (!filter_var($request->post('companyEmail'), FILTER_VALIDATE_EMAIL)) {
            Session::flash('error', Translation::get('form_invalid_email_message'));
            return false;
        }

        if (!empty($request->post('facebook')) && !filter_var($request->post('facebook'), FILTER_VALIDATE_URL)) {
            Session::flash('error', Translation::get('form_invalid_url'));
            return false;
        }

        if (!empty($request->post('instagram')) && !filter_var($request->post('instagram'), FILTER_VALIDATE_URL)) {
            Session::flash('error', Translation::get('form_invalid_url'));
            return false;
        }

        if (!empty($request->post('linkedIn')) && !filter_var($request->post('linkedIn'), FILTER_VALIDATE_URL)) {
            Session::flash('error', Translation::get('form_invalid_url'));
            return false;
        }

        if (!empty($request->post('youtube')) && !filter_var($request->post('youtube'), FILTER_VALIDATE_URL)) {
            Session::flash('error', Translation::get('form_invalid_url'));
            return false;
        }

        if (!empty($request->post('twitter')) && !filter_var($request->post('twitter'), FILTER_VALIDATE_URL)) {
            Session::flash('error', Translation::get('form_invalid_url'));
            return false;
        }

        if (strstr($request->post('studentEmail'), '@') !== false) {
            Session::flash('error', Translation::get('form_invalid_email_domain'));
            return false;
        }

        if (strstr($request->post('teacherEmail'), '@') !== false) {
            Session::flash('error', Translation::get('form_invalid_email_domain'));
            return false;
        }

        if (preg_match('/^[0-9]{10}+$/', $request->post(''))) {
            Session::flash('error', Translation::get('form_invalid_phone_number'));
            return false;
        }

        if (!preg_match(
            "/^\W*[1-9]{1}[0-9]{3}\W*[a-zA-Z]{2}\W*$/",
            strtoupper(str_replace(" ", "", $request->post('companyPostcode')))
        )
        ) {
            return false;
        }

        if (isset($this->_parameters['companyPostcode'])) {
            $this->_parameters['companyPostcode'] = strtoupper(str_replace(" ", "", $request->post('companyPostcode')));
        }

        return true;
    }
}
