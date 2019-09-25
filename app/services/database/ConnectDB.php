<?php

namespace App\services\database;

use App\services\core\Config;
use App\services\core\Validate;
use App\services\exceptions\CustomException;
use PDO;
use PDOException;
use PDOStatement;

class ConnectDB
{
    /**
     * The pdo object.
     *
     * @var PDO
     */
    protected $pdo;

    /**
     * The pdo statement object.
     *
     * @var PDOStatement
     */
    protected $statement;

    /**
     * The array of the values to bind to the query.
     *
     * @var array
     */
    protected $bindValues = [];

    /**
     * The last inserted ID.
     *
     * @var int
     */
    protected $lastInsertedId = 0;

    /**
     * The message which shall be returned if the query is executed.
     *
     * @var string
     */
    protected $message = '';

    /**
     * Is the executed query successful?
     *
     * @var bool
     */
    protected $successful = false;

    /**
     * Construct the pdo object.
     */
    protected function __construct()
    {
        try {
            $pdo = new PDO(
                Config::get('databaseServer') .
                ';dbname=' . Config::get('databaseName') .
                ';charset=' . Config::get('databaseCharset'),
                Config::get('databaseUsername'),
                Config::get('databasePassword'),
                Config::get('databaseOptions')
            );
            Validate::var($pdo)->isObject();

            $this->pdo = $pdo;
        } catch (PDOException $PDOException) {
            CustomException::handle($PDOException);
        }
    }
}
