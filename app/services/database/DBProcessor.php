<?php

namespace App\services\database;

use App\services\core\Sanitize;
use App\services\exceptions\CustomException;
use PDO;
use PDOException;
use PDOStatement;

class DBProcessor extends ConnectDB
{
    /**
     * DBProcessor constructor.
     *
     * @param string $query      The query to execute on the database.
     * @param array  $bindValues The values to bind to the query.
     */
    public function __construct(string $query, array $bindValues)
    {
        try {
            parent::__construct();

            $this->statement = $this->pdo->prepare($query);
            $this->bindValues = $bindValues;

            $this->_bindValues($this->bindValues);
            $this->statement->execute();

            $this->lastInsertedId = intval($this->pdo->lastInsertId());
            $this->successful = true;
        } catch (PDOException $PDOException) {
            CustomException::handle(
                $PDOException,
                'Used query: "' . $query . '" The values to bind to the query: ',
                $bindValues
            );
        } catch (CustomException $customException) {
            CustomException::handle($customException);
        }
    }

    /**
     * Bind each value with the specified column.
     *
     * @param array $bindValues The values to bind to the query.
     *
     * @return PDOStatement
     * @throws CustomException
     * @throws PDOException
     */
    private function _bindValues(array $bindValues)
    {
        foreach ($bindValues as $bindColumn => $bindValue) {
            if (!is_scalar($bindValue)) {
                $bindValue = '';
            }

            $sanitize = new Sanitize($bindValue);
            $this->statement->bindValue(
                ":{$bindColumn}",
                $sanitize->data(),
                PDO::PARAM_STR
            );
        }

        return $this->statement;
    }

    /**
     * Fetch all records from the database with the given fetch method.
     *
     * @param int $fetchMethod The used method to fetch the database records.
     *
     * @return mixed
     */
    public function fetchAll(int $fetchMethod)
    {
        return $this->statement->fetchAll($fetchMethod);
    }

    /**
     * Fetch one record from the database with the given fetch method.
     *
     * @param int $fetchMethod The used method to fetch the database record.
     *
     * @return mixed
     */
    public function fetch(int $fetchMethod)
    {
        return $this->statement->fetch($fetchMethod);
    }

    /**
     * Fetch all the records from the database to an object.
     *
     * @return array
     */
    public function all()
    {
        $result = $this->statement->fetchAll(PDO::FETCH_OBJ);

        return is_array($result) ? $result : [];
    }

    /**
     * Fetch all the records from the database to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $result = $this->statement->fetchAll(PDO::FETCH_NAMED);

        return is_array($result) ? $result : [];
    }

    /**
     * Fetch the first record found in the database to an object.
     *
     * @return object|null
     */
    public function first()
    {
        $result = $this->statement->fetch(PDO::FETCH_OBJ);

        return is_object($result) ? $result : null;
    }

    /**
     * Get the last inserted ID.
     *
     * @return int
     */
    public function getLastInsertedId()
    {
        return $this->lastInsertedId;
    }

    /**
     * Count all records that are selected from the database.
     *
     * @return int
     */
    public function getNumberOfItems()
    {
        $items = $this->statement->fetchAll(PDO::FETCH_NAMED);

        return is_array($items) ? count($items) : 0;
    }

    /**
     * Get the successful state.
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->successful;
    }
}
