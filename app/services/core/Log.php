<?php

namespace App\services\core;

use App\services\exceptions\CustomException;
use Exception;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Monolog\Processor\WebProcessor;

class Log
{
    /**
     * The logger object.
     *
     * @var Logger
     */
    private static $_logger;

    /**
     * Construct the logger.
     */
    private function __construct()
    {
        try {
            self::$_logger = new Logger('CC Westeinde');
            self::$_logger->pushHandler(
                new RotatingFileHandler(
                    START_PATH . '/storage/logs/app.log',
                    365,
                    Logger::DEBUG
                )
            );
            self::$_logger->pushHandler(new FirePHPHandler());
            self::$_logger->pushProcessor(new WebProcessor());
        } catch (Exception $exception) {
            CustomException::handle($exception);
        }
    }

    /**
     * Log info
     *
     * @param string $message The log message.
     * @param array  $context The log context.
     *
     * @return void
     */
    public static function info(string $message, array $context = [])
    {
        new static();
        self::$_logger->info($message, $context);
    }

    /**
     * Log error info
     *
     * @param string $message The log message.
     * @param array  $context The log context.
     *
     * @return void
     */
    public static function error(string $message, array $context = [])
    {
        new static();
        self::$_logger->error($message, $context);
    }
}
