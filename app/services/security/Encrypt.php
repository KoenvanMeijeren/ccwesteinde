<?php


namespace App\services\security;

use App\services\core\Config;
use App\services\core\Validate;
use App\services\exceptions\CustomException;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use Exception;

class Encrypt
{
    /**
     * The data to be encrypted or decrypted.
     *
     * @var string
     */
    private $_data;

    /**
     * Construct the data.
     *
     * @param mixed $data The data to be saved.
     */
    public function __construct($data)
    {
        Validate::var($data)->isScalar()->isNotEmpty();
        $this->_data = $data;
    }

    /**
     * Encrypt the data.
     *
     * @return bool|string
     */
    public function encrypt()
    {
        try {
            $key = self::_loadKeyFromConfig();

            return Crypto::encrypt($this->_data, $key);
        } catch (Exception $exception) {
            CustomException::handle($exception);
            return false;
        }
    }

    /**
     * Decrypt the data.
     *
     * @return bool|string
     */
    public function decrypt()
    {
        try {
            $key = $this->_loadKeyFromConfig();

            return Crypto::decrypt($this->_data, $key);
        } catch (Exception $exception) {
            CustomException::handle($exception);
            return false;
        }
    }

    /**
     * Load the key from the config.
     *
     * @return bool|Key|mixed|string|null
     */
    private function _loadKeyFromConfig()
    {
        try {
            $key = Config::get('encryptionToken');
            $key = Key::loadFromAsciiSafeString($key);

            return $key;
        } catch (Exception $exception) {
            CustomException::handle($exception);
            return false;
        }
    }
}
