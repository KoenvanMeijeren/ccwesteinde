<?php

namespace App\services\exceptions;

use App\services\core\Config;
use App\services\core\Log;
use App\services\core\View;
use App\services\parsers\ParserFactory;
use Exception;

class CustomException extends Exception
{
    /**
     * The exception object.
     *
     * @var Exception
     */
    private static $_exception;

    /**
     * The context of the exception to provide helpful debug info.
     *
     * @var mixed
     */
    private static $_context;

    /**
     * Handle the exception that has been thrown.
     *
     * @param Exception $exception  The exception.
     * @param mixed     ...$context The context provides helpful debug info..
     *
     * @return mixed|view
     */
    public static function handle(Exception $exception, ...$context)
    {
        self::$_exception = $exception;
        self::$_context = $context;

        $parser = new ParserFactory();
        $jsonParser = $parser->createJsonParser();
        self::$_context = $jsonParser->encode(self::$_context);

        Log::error(strip_tags(self::_buildHtmlException()));

        if (Config::get('env') === 'development') {
            echo self::_buildHtmlException();
            exit();
        }

        return new View('errors/500');
    }

    /**
     * Convert the exception into html.
     *
     * @return string
     */
    private static function _buildHtmlException()
    {
        $exception = self::$_exception;

        $error = "Context: " . self::$_context;
        $error .= "<h2>Exception: {$exception->getMessage()} </h2>";
        $error .= "On line {$exception->getLine()} <br>";
        $error .= "In file {$exception->getFile()} <br>";
        $error .= "In code {$exception->getCode()} <br><hr>";
        $error .= self::_buildStackTrace();

        return $error;
    }

    /**
     * Build the stack trace of the error.
     *
     * @return string
     */
    private static function _buildStackTrace()
    {
        $exception = self::$_exception;
        $trace = 0;
        $error = '';

        foreach ($exception->getTrace() as $singleTrace) {
            if (isset($singleTrace['line']) && !empty($singleTrace['line'])) {
                $error .= "On line {$singleTrace['line']} <br>";
            }

            if (isset($singleTrace['file']) && !empty($singleTrace['file'])) {
                $error .= "In file {$singleTrace['file']} <br>";
            }

            if (isset($singleTrace['function']) && !empty($singleTrace['function'])) {
                $error .= "In function {$singleTrace['function']} ";
            }

            if (isset($singleTrace['class']) && !empty($singleTrace['class'])) {
                $error .= "in class {$singleTrace['class']} ";
            }

            $error .= "<br><br>";
            $trace++;
        }

        return $error;
    }
}
