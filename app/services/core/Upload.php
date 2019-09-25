<?php


namespace App\services\core;

use App\services\exceptions\CustomException;
use App\services\session\Session;
use Exception;
use Sirius\Upload\Handler as UploadHandler;

class Upload
{
    /**
     * The file to be uploaded.
     *
     * @var array
     */
    private $_file = [];

    /**
     * The path of the uploaded file.
     *
     * @var string
     */
    private $_path = '';

    /**
     * The striped path of the uploaded file.
     *
     * @var string
     */
    private $_stripedPath = '';

    /**
     * The stored path of the uploaded file.
     *
     * @var string
     */
    private $_storedPath = '';

    /**
     * Prepare the file to be uploaded.
     *
     * @param array  $file        The file to be uploaded.
     * @param string $path        The path to store the file in.
     * @param string $stripedPath The striped path to store the file in.
     */
    public function __construct(
        array $file,
        string $path = STORAGE_PATH . '/media/',
        string $stripedPath = '/storage/media/'
    ) {
        $this->_file = $file;
        $this->_path = $path;
        $this->_stripedPath = $stripedPath;
    }

    /**
     * Prepare the file that is going to upload.
     *
     * @return bool
     */
    public function prepare()
    {
        if ($this->_convertFileName()) {
            return true;
        }

        return false;
    }

    /**
     * Get the file location if the file exists.
     *
     * @return string
     */
    public function getFileIfItExists()
    {
        $fileLocation = $this->_stripedPath . $this->_file['name'];

        return file_exists($_SERVER['DOCUMENT_ROOT'] . $fileLocation) ? $fileLocation : '';
    }

    /**
     * Convert the file name into a non readable name.
     *
     * @return bool
     */
    private function _convertFileName()
    {
        $randomBytes = bin2hex($this->_file['name']);
        try {
            // try to generate a random string of 99 characters
            $randomBytes .= bin2hex(random_bytes(40));
        } catch (\Exception $exception) {
            CustomException::handle($exception);
        }

        if (isset($this->_file['type']) && isset($this->_file['name'])) {
            switch ($this->_file['type']) {
            case 'image/png':
                $this->_file['name'] = $randomBytes . '.png';
                return true;
                    break;
            case 'image/jpg':
                $this->_file['name'] = $randomBytes . '.jpg';
                return true;
                    break;
            case 'image/jpeg':
                $this->_file['name'] = $randomBytes . '.jpeg';
                return true;
                    break;
            case 'image/svg+xml':
                $this->_file['name'] = $randomBytes . '.svg';
                return true;
                    break;
            default:
                Session::flash('error', Translation::get('not_allowed_file_upload'));
                return false;
                    break;
            }
        }

        Session::flash('error', Translation::get('error_while_uploading_file'));
        return false;
    }

    /**
     * Upload the file.
     *
     * @return bool
     */
    public function execute()
    {
        $uploadHandler = new UploadHandler($this->_path);

        $uploadHandler->addRule(
            'extension',
            ['allowed' => ['jpg', 'jpeg', 'png', 'svg']],
            '{label} should be a valid image (jpg, jpeg, png, svg)',
            'Profile picture'
        );
        $uploadHandler->addRule('size', ['max' => '8M'], '{label} should have less than {max}', 'Profile picture');

        $result = $uploadHandler->process($this->_file);
        if ($result->isValid()) {
            try {
                $result->confirm();
                $filename = $result->name ?? '';
                $this->_setStoredFilePath($this->_stripedPath . $filename);

                return true;
            } catch (Exception $exception) {
                $result->clear();
                CustomException::handle($exception);
                return false;
            }
        }

        Session::flash('error', Translation::get('error_while_uploading_file'));
        return false;
    }

    /**
     * Set the stored file path.
     *
     * @param string $path The stored path of the file.
     *
     * @return void
     */
    private function _setStoredFilePath(string $path)
    {
        $this->_storedPath = $path;
    }

    /**
     * Get the stored file path.
     *
     * @return string
     */
    public function getStoredFilePath()
    {
        return $this->_storedPath;
    }
}
