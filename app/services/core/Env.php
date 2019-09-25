<?php


namespace App\services\core;

use App\services\exceptions\CustomException;
use Monolog\ErrorHandler;
use Monolog\Formatter\HtmlFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\WebProcessor;

class Env
{
    /**
     * The host of the app.
     *
     * @var string
     */
    private $_host;

    /**
     * The env of the app.
     *
     * @var string
     */
    private $_env;

    /**
     * The config file location of the app.
     *
     * @var string
     */
    private $_configFile;

    /**
     * Construct the live url and host.
     * Set the env.
     */
    public function __construct()
    {
        $this->_host = $_SERVER['HTTP_HOST'] ?? '';

        $this->_setEnv();
        Config::set('env', $this->_env);
    }

    /**
     * Set the current env based on the url.
     *
     * @return void
     */
    private function _setEnv()
    {
        if (strstr($this->_host, 'localhost') || strstr($this->_host, '127.0.0.1')) {
            $this->_env = 'development';
            $this->_configFile = CONFIG_PATH . '/dev_config.php';
        } else {
            $this->_env = 'production';
            $this->_configFile = CONFIG_PATH . '/production_config.php';
        }

        loadFile($this->_configFile);

        ini_set('display_errors', ($this->_env === 'development' ? 1 : 0));
        ini_set('display_startup_errors', ($this->_env === 'development' ? 1 : 0));
        error_reporting(($this->_env === 'development' ? E_ALL : -1));

        $this->_setErrorHandling();
    }

    /**
     * Set the error handling.
     *
     * @return void
     */
    private function _setErrorHandling()
    {
        try {
            $logger = new Logger('CC Westeinde');
            $logger->pushHandler(new RotatingFileHandler(START_PATH . '/storage/logs/app.log', 365, Logger::DEBUG));

            if ($this->_env === 'development') {
                $stream = new StreamHandler('php://output', Logger::DEBUG);
                $stream->setFormatter(new HtmlFormatter());

                $logger->pushHandler($stream);
                $logger->pushProcessor(new WebProcessor());
            }

            $handler = new ErrorHandler($logger);
            $handler->registerErrorHandler([], false);
            $handler->registerExceptionHandler();
            $handler->registerFatalHandler();
        } catch (\Exception $exception) {
            CustomException::handle($exception);
        }
    }
}
