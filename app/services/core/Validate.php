<?php


namespace App\services\core;

use App\services\exceptions\CustomException;

class Validate
{
    /**
     * The var to be validated.
     *
     * @var mixed
     */
    private static $_var;

    /**
     * Store the variable to
     *
     * @param mixed $var The var to be validated.
     *
     * @return Validate
     */
    public static function var($var)
    {
        self::$_var = $var;

        return new static();
    }

    /**
     * Check the variable if it is not empty.
     *
     * @return Validate
     */
    public function isNotEmpty()
    {
        try {
            if ((self::$_var != 0 || self::$_var != '0') && empty(self::$_var)) {
                throw new CustomException('Empty variable given. The variable cannot be empty.');
            }
        } catch (CustomException $customException) {
            CustomException::handle($customException, self::$_var);
        }

        return new static();
    }

    /**
     * Check the variable if it is a scalar type.
     *
     * @return Validate
     */
    public function isScalar()
    {
        try {
            if (!is_scalar(self::$_var)) {
                throw new CustomException(gettype(self::$_var) . ' given. The variable must be a scalar type.');
            }
        } catch (CustomException $customException) {
            CustomException::handle($customException);
        }

        return new static();
    }

    /**
     * Check the variable if it is a string.
     *
     * @return Validate
     */
    public function isString()
    {
        try {
            if (!is_string(self::$_var)) {
                throw new CustomException(gettype(self::$_var) . ' given. The variable must be a string.');
            }
        } catch (CustomException $customException) {
            CustomException::handle($customException);
        }

        return new static();
    }

    /**
     * Check the variable if it is an url.
     *
     * @return Validate
     */
    public function isUrl()
    {
        try {
            if (!filter_var(self::$_var, FILTER_VALIDATE_URL)) {
                throw new CustomException('Invalid url given.');
            }
        } catch (CustomException $customException) {
            CustomException::handle($customException, self::$_var);
        }

        return new static();
    }

    /**
     * Check the variable if it is an int.
     *
     * @return Validate
     */
    public function isInt()
    {
        try {
            if (!is_int(self::$_var)) {
                throw new CustomException(gettype(self::$_var) . ' given. The variable must be an int.');
            }
        } catch (CustomException $customException) {
            CustomException::handle($customException);
        }

        return new static();
    }

    /**
     * Check the variable if it is an array.
     *
     * @return Validate
     */
    public function isArray()
    {
        try {
            if (!is_array(self::$_var)) {
                throw new CustomException(gettype(self::$_var) . ' given. The variable must be an array.');
            }
        } catch (CustomException $customException) {
            CustomException::handle($customException);
        }

        return new static();
    }

    /**
     * Check the variable if it is an object.
     *
     * @return Validate
     */
    public function isObject()
    {
        try {
            if (!is_object(self::$_var)) {
                throw new CustomException(gettype(self::$_var) . ' given. The variable must be an object.');
            }
        } catch (CustomException $customException) {
            CustomException::handle($customException);
        }

        return new static();
    }

    /**
     * Check if the method exists in the object.
     *
     * @param string $methodName The method to be check for existing.
     *
     * @return Validate
     */
    public function methodExists(string $methodName)
    {
        try {
            if (!method_exists(self::$_var, $methodName)) {
                throw new CustomException("The called method {$methodName} does not exist in the object " . serialize(self::$_var) . ".");
            }
        } catch (CustomException $customException) {
            CustomException::handle($customException);
        }

        return new static();
    }

    /**
     * Check if the file exists.
     *
     * @return Validate
     */
    public function fileExists()
    {
        try {
            if (!file_exists(self::$_var)) {
                throw new CustomException('Could not load the given file ' . self::$_var);
            }
        } catch (CustomException $customException) {
            CustomException::handle($customException);
        }

        return new static();
    }
}
