<?php


namespace App\services\core;

class Sanitize
{
    /**
     * The data to be sanitized.
     *
     * @var string
     */
    private $_data;

    /**
     * The type of the data.
     *
     * @var string
     */
    private $_type;

    /**
     * The flags for htmlspecialchars filtering.
     *
     * @var int
     */
    private $_flags;

    /**
     * The encoding for htmlspecialchars filtering.
     *
     * @var string
     */
    private $_encoding;

    /**
     * Construct the data.
     *
     * @param mixed  $data     The data to be sanitized.
     * @param string $type     The type of the data.
     * @param int    $flags    The flags for htmlspecialchars filtering.
     * @param string $encoding The encoding for htmlspecialchars filtering.
     */
    public function __construct($data, string $type = '', int $flags = ENT_NOQUOTES, string $encoding = 'UTF-8')
    {
        Validate::var($data)->isScalar();
        $this->_data = $data;

        if (empty($type)) {
            $type = gettype($this->_data);
        }
        $this->_type = $type;
        $this->_flags = $flags;
        $this->_encoding = $encoding;
    }

    /**
     * Strip the data to prevent XSS or something like that
     *
     * @return mixed
     */
    public function data()
    {
        $data = htmlspecialchars($this->_data, $this->_flags, $this->_encoding);
        $data = self::_filterData($data, $this->_type);

        return $data;
    }

    /**
     * Filter the data.
     *
     * @param mixed  $data The data to be filtered.
     * @param string $type The type of the data.
     *
     * @return mixed
     */
    private function _filterData($data, string $type)
    {
        switch ($type) {
        case 'string':
            $data = filter_var($data, FILTER_SANITIZE_STRING);
            break;
        case 'integer':
            $data = filter_var($data, FILTER_SANITIZE_NUMBER_INT);
            break;
        case 'float':
            $data = filter_var($data, FILTER_SANITIZE_NUMBER_FLOAT);
            break;
        case 'double':
            $data = filter_var($data, FILTER_SANITIZE_NUMBER_FLOAT);
            break;
        default:
            $data = filter_var($data);
            break;
        }

        return $data;
    }
}
