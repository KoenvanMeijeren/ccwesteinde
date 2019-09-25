<?php

namespace App\services\database;

use App\services\core\Sanitize;
use App\services\core\Validate;

class DB
{
    /**
     * The table to execute the query on.
     *
     * @var string
     */
    private static $_table = '';

    /**
     * The quantity of inner joins in the query.
     *
     * @var int
     */
    private static $_quantityInnerJoins = 0;

    /**
     * The query.
     *
     * @var string
     */
    private $_query = '';

    /**
     * The values for using in the query.
     *
     * @var array
     */
    private $_values = [];

    /**
     * Set the table to use in the queries.
     *
     * @param string $table              The table to be used in the query.
     * @param int    $quantityInnerJoins The quantity inner joins in the query.
     *
     * @return DB
     */
    public static function table(string $table, int $quantityInnerJoins = 0)
    {
        Validate::var($table)->isString()->isNotEmpty();

        self::$_table = $table;
        self::$_quantityInnerJoins = $quantityInnerJoins;

        return new self;
    }

    /**
     * The SELECT statement is used to select data from a database.
     * The data returned is stored in a result table, called the result-set.
     *
     * @param mixed ...$columns The columns to select from the database.
     *
     * @return $this
     */
    public function select(...$columns)
    {
        $columns = implode(', ', $columns);
        $hooks = '';
        for ($x = 0; $x < self::$_quantityInnerJoins; $x++) {
            $hooks .= '(';
        }

        Validate::var($columns)->isString()->isNotEmpty();
        $this->_query .= "SELECT {$columns} FROM {$hooks}" . self::$_table . ' ';

        return $this;
    }

    /**
     * The UNION operator is used to combine the result-set of two or more SELECT statements.
     *  - Each SELECT statement within UNION must have the same number of columns
     *  - The columns must also have similar data types
     *  - The columns in each SELECT statement must also be in the same order
     *
     * The UNION operator selects only distinct values by default. To allow duplicate values, use UNION ALL:
     *
     * @param string $table      The table to be used in the query.
     * @param mixed  ...$columns The columns to select union from the database.
     *
     * @return $this
     */
    public function selectUnion(string $table, ...$columns)
    {
        $columns = implode(', ', $columns);
        $hooks = '';
        for ($x = 0; $x < self::$_quantityInnerJoins; $x++) {
            $hooks .= '(';
        }

        Validate::var($table)->isString()->isNotEmpty();
        Validate::var($columns)->isString()->isNotEmpty();
        $this->_query .= "UNION SELECT {$columns} FROM {$hooks} {$table} ";

        return $this;
    }

    /**
     * The UNION operator is used to combine the result-set of two or more SELECT statements.
     *  - Each SELECT statement within UNION must have the same number of columns
     *  - The columns must also have similar data types
     *  - The columns in each SELECT statement must also be in the same order
     *
     * The UNION operator selects only distinct values by default. To allow duplicate values, use UNION ALL:
     *
     * @param string $table      The table to be used in the query.
     * @param mixed  ...$columns The columns to select union all from the database.
     *
     * @return $this
     */
    public function selectUnionAll(string $table, ...$columns)
    {
        $columns = implode(', ', $columns);
        $hooks = '';
        for ($x = 0; $x < self::$_quantityInnerJoins; $x++) {
            $hooks .= '(';
        }

        Validate::var($table)->isString()->isNotEmpty();
        Validate::var($columns)->isString()->isNotEmpty();
        $this->_query .= "UNION ALL SELECT {$columns} FROM {$hooks} {$table} ";

        return $this;
    }

    /**
     * The SELECT DISTINCT statement is used to return only distinct (different) values.
     *
     * @param mixed ...$columns The columns to select distinct from the database.
     *
     * @return $this
     */
    public function selectDistinct(...$columns)
    {
        $columns = implode(', ', $columns);
        $hooks = '';
        for ($x = 0; $x < self::$_quantityInnerJoins; $x++) {
            $hooks .= '(';
        }

        Validate::var($columns)->isString()->isNotEmpty();
        $this->_query .= "SELECT DISTINCT {$columns} FROM {$hooks}" . self::$_table . ' ';

        return $this;
    }

    /**
     * The MIN() function returns the smallest value of the selected column.
     *
     * @param mixed ...$columns The columns to select min from the database.
     *
     * @return $this
     */
    public function selectMin(...$columns)
    {
        $columns = implode(', ', $columns);
        $hooks = '';
        for ($x = 0; $x < self::$_quantityInnerJoins; $x++) {
            $hooks .= '(';
        }

        Validate::var($columns)->isString()->isNotEmpty();
        $this->_query .= "SELECT MIN({$columns}) FROM {$hooks}" . self::$_table . ' ';

        return $this;
    }

    /**
     * The MAX() function returns the largest value of the selected column.
     *
     * @param mixed ...$columns The columns to select max from the database.
     *
     * @return $this|void
     */
    public function selectMax(...$columns)
    {
        $columns = implode(', ', $columns);
        $hooks = '';
        for ($x = 0; $x < self::$_quantityInnerJoins; $x++) {
            $hooks .= '(';
        }

        Validate::var($columns)->isString()->isNotEmpty();
        $this->_query .= "SELECT MAX({$columns}) FROM {$hooks}" . self::$_table . ' ';

        return $this;
    }

    /**
     * The COUNT() function returns the number of rows that matches a specified criteria.
     *
     * @param mixed ...$columns The columns to select count from the database.
     *
     * @return $this
     */
    public function selectCount(...$columns)
    {
        $columns = implode(', ', $columns);
        $hooks = '';
        for ($x = 0; $x < self::$_quantityInnerJoins; $x++) {
            $hooks .= '(';
        }

        Validate::var($columns)->isString()->isNotEmpty();
        $this->_query .= "SELECT COUNT({$columns}) FROM {$hooks}" . self::$_table . ' ';

        return $this;
    }

    /**
     * The AVG() function returns the average value of a numeric column.
     *
     * @param mixed ...$columns The columns to select avg from the database.
     *
     * @return $this
     */
    public function selectAvg(...$columns)
    {
        $columns = implode(', ', $columns);
        $hooks = '';
        for ($x = 0; $x < self::$_quantityInnerJoins; $x++) {
            $hooks .= '(';
        }

        Validate::var($columns)->isString()->isNotEmpty();
        $this->_query .= "SELECT AVG({$columns}) FROM {$hooks}" . self::$_table . ' ';

        return $this;
    }

    /**
     * The SUM() function returns the total sum of a numeric column.
     *
     * @param mixed ...$columns The columns to select sum from the database.
     *
     * @return $this
     */
    public function selectSum(...$columns)
    {
        $columns = implode(', ', $columns);
        $hooks = '';
        for ($x = 0; $x < self::$_quantityInnerJoins; $x++) {
            $hooks .= '(';
        }

        Validate::var($columns)->isString()->isNotEmpty();
        $this->_query .= "SELECT SUM({$columns}) FROM {$hooks}" . self::$_table . ' ';

        return $this;
    }

    /**
     * The INNER JOIN keyword selects records that have matching values in both tables.
     *
     * @param string $table          The table to inner join on.
     * @param string $tableOneColumn The first table column to inner join on.
     * @param string $tableTwoColumn The second table column to inner join on.
     *
     * @return $this
     */
    public function innerJoin(string $table, string $tableOneColumn, string $tableTwoColumn)
    {
        $hook = '';
        if (!empty(self::$_quantityInnerJoins)) {
            $hook = ')';
        }

        Validate::var($table)->isString()->isNotEmpty();
        Validate::var($tableOneColumn)->isString()->isNotEmpty();
        Validate::var($tableTwoColumn)->isString()->isNotEmpty();
        $this->_query .= "INNER JOIN {$table} ON {$tableOneColumn} = {$tableTwoColumn}{$hook} ";

        return $this;
    }

    /**
     * The LEFT JOIN keyword returns all records from the left table (table1),
     * and the matched records from the right table (table2).
     * The result is NULL from the right side, if there is no match.
     *
     * @param string $table          The table to left join on.
     * @param string $tableOneColumn The first table column to left join on.
     * @param string $tableTwoColumn The second table column to left join on.
     *
     * @return $this
     */
    public function leftJoin(string $table, string $tableOneColumn, string $tableTwoColumn)
    {
        $hook = '';
        if (!empty(self::$_quantityInnerJoins)) {
            $hook = ')';
        }

        Validate::var($table)->isString()->isNotEmpty();
        Validate::var($tableOneColumn)->isString()->isNotEmpty();
        Validate::var($tableTwoColumn)->isString()->isNotEmpty();
        $this->_query .= "LEFT JOIN {$table} ON {$tableOneColumn} = {$tableTwoColumn}{$hook} ";

        return $this;
    }

    /**
     * The RIGHT JOIN keyword returns all records from the right table (table2),
     * and the matched records from the left table (table1).
     * The result is NULL from the left side, when there is no match.
     *
     * @param string $table          The table to right join on.
     * @param string $tableOneColumn The first table column to right join on.
     * @param string $tableTwoColumn The second table column to right join on.
     *
     * @return $this
     */
    public function rightJoin(string $table, string $tableOneColumn, string $tableTwoColumn)
    {
        $hook = '';
        if (!empty(self::$_quantityInnerJoins)) {
            $hook = ')';
        }

        Validate::var($table)->isString()->isNotEmpty();
        Validate::var($tableOneColumn)->isString()->isNotEmpty();
        Validate::var($tableTwoColumn)->isString()->isNotEmpty();
        $this->_query .= "RIGHT JOIN {$table} ON {$tableOneColumn} = {$tableTwoColumn}{$hook} ";

        return $this;
    }

    /**
     * The FULL OUTER JOIN keyword return all records when
     * there is a match in either left (table1) or right (table2) table records.
     *
     * @param string $table          The table to full outer join on.
     * @param string $tableOneColumn The first table column to full outer join on.
     * @param string $tableTwoColumn The second table column to full outer join on.
     *
     * @return $this|void
     */
    public function fullOuterJoin(string $table, string $tableOneColumn, string $tableTwoColumn)
    {
        $hook = '';
        if (!empty(self::$_quantityInnerJoins)) {
            $hook = ')';
        }

        Validate::var($table)->isString()->isNotEmpty();
        Validate::var($tableOneColumn)->isString()->isNotEmpty();
        Validate::var($tableTwoColumn)->isString()->isNotEmpty();
        $this->_query .= "FULL OUTER JOIN {$table} ON {$tableOneColumn} = {$tableTwoColumn}{$hook} ";

        return $this;
    }

    /**
     * The WHERE clause is used to filter records.
     * The WHERE clause is used to extract only those records that fulfill a specified condition.
     *
     * @param string $column    The column to be used in the where statement.
     * @param string $operator  The operator to be used in the where statement.
     * @param mixed  $condition The condition to be used in the where statement.
     *
     * @return $this
     */
    public function where(string $column, string $operator, $condition)
    {
        Validate::var($column)->isString()->isNotEmpty();
        Validate::var($operator)->isString()->isNotEmpty();
        $bindColumn = str_replace('.', '', $column);

        if (!strpos($this->_query, 'WHERE')) {
            $this->_query .= "WHERE {$column} {$operator} :{$bindColumn} ";
        } else {
            $this->_query .= "AND {$column} {$operator} :{$bindColumn} ";
        }

        $this->_values += [$bindColumn => $condition];

        return $this;
    }

    /**
     * The EXISTS operator is used to test for the existence of any record in a sub query.
     * The EXISTS operator returns true if the sub query returns one or more records.
     *
     * @param string $query  The query to be used in the where exists statement.
     * @param array  $values The values to bind to the query.
     *
     * @return $this
     */
    public function whereExists(string $query, array $values)
    {
        Validate::var($query)->isString()->isNotEmpty();
        Validate::var($values)->isArray()->isNotEmpty();

        if (!strpos($this->_query, 'WHERE')) {
            $this->_query .= "WHERE EXISTS ({$query}) ";
        } else {
            $this->_query .= "AND EXISTS ({$query}) ";
        }

        foreach ($values as $column => $value) {
            Validate::var($value)->isScalar()->isNotEmpty();
            $this->_values += [$column => $value];
        }

        return $this;
    }

    /**
     * The ANY and ALL operators are used with a WHERE or HAVING clause.
     * The ANY operator returns true if any of the sub query values meet the condition.
     * The ALL operator returns true if all of the sub query values meet the condition.
     *
     * @param string $column   The column to be used in the where any statement.
     * @param string $operator The operator to be used in the where any statement.
     * @param string $query    The query to be used in the where any statement.
     * @param array  $values   The values to bind to the query.
     *
     * @return $this
     */
    public function whereAny(string $column, string $operator, string $query, array $values)
    {
        Validate::var($column)->isString()->isNotEmpty();
        Validate::var($operator)->isString()->isNotEmpty();
        Validate::var($query)->isString()->isNotEmpty();
        Validate::var($values)->isArray()->isNotEmpty();

        if (!strpos($this->_query, 'WHERE')) {
            $this->_query .= "WHERE {$column} {$operator} ANY ({$query}) ";
        } else {
            $this->_query .= "AND {$column} {$operator} ANY ({$query}) ";
        }

        foreach ($values as $column => $value) {
            Validate::var($value)->isScalar()->isNotEmpty();
            $this->_values += [$column => $value];
        }

        return $this;
    }

    /**
     * The ANY and ALL operators are used with a WHERE or HAVING clause.
     * The ANY operator returns true if any of the sub query values meet the condition.
     * The ALL operator returns true if all of the sub query values meet the condition.
     *
     * @param string $column   The column to be used in the where all statement.
     * @param string $operator The operator to be used in the where all statement.
     * @param string $query    The query to be used in the where all statement.
     * @param array  $values   The values to bind to the query.
     *
     * @return $this
     */
    public function whereAll(string $column, string $operator, string $query, array $values)
    {
        Validate::var($column)->isString()->isNotEmpty();
        Validate::var($operator)->isString()->isNotEmpty();
        Validate::var($query)->isString()->isNotEmpty();
        Validate::var($values)->isArray()->isNotEmpty();

        if (!strpos($this->_query, 'WHERE')) {
            $this->_query .= "WHERE {$column} {$operator} ALL ({$query}) ";
        } else {
            $this->_query .= "AND {$column} {$operator} ALL ({$query}) ";
        }

        foreach ($values as $column => $value) {
            Validate::var($value)->isScalar()->isNotEmpty();
            $this->_values += [$column => $value];
        }

        return $this;
    }

    /**
     * Add where not statement to the query.
     *
     * @param string $column    The column to be used in the where not statement.
     * @param string $operator  The operator to be used in the where not statement.
     * @param mixed  $condition The operator to be used in the where not statement.
     *
     * @return $this
     */
    public function whereNot(string $column, string $operator, $condition)
    {
        Validate::var($column)->isString()->isNotEmpty();
        Validate::var($operator)->isString()->isNotEmpty();
        Validate::var($condition)->isScalar()->isNotEmpty();

        if (!strpos($this->_query, 'WHERE')) {
            $this->_query .= "WHERE NOT {$column} {$operator} :{$column} ";
        } else {
            $this->_query .= "AND NOT {$column} {$operator} :{$column} ";
        }

        $this->_values += [$column => $condition];

        return $this;
    }

    /**
     * The IS NULL operator is used to test for empty values (NULL values).
     *
     * @param mixed ...$columns The columns to be used in the where is null statement.
     *
     * @return $this
     */
    public function whereIsNull(...$columns)
    {
        Validate::var($columns)->isArray()->isNotEmpty();

        $columns = implode(', ', $columns);
        if (!strpos($this->_query, 'WHERE')) {
            $this->_query .= "WHERE {$columns} IS NULL ";
        } else {
            $this->_query .= "AND {$columns} IS NULL";
        }

        return $this;
    }

    /**
     * The IS NOT NULL operator is used to test for empty values (NULL values).
     *
     * @param mixed ...$columns The columns to be used in the where is not null statement.
     *
     * @return $this
     */
    public function whereIsNotNull(...$columns)
    {
        Validate::var($columns)->isArray()->isNotEmpty();

        $columns = implode(', ', $columns);
        if (!strpos($this->_query, 'WHERE')) {
            $this->_query .= "WHERE {$columns} IS NOT NULL ";
        } else {
            $this->_query .= "AND {$columns} IS NOT NULL";
        }

        return $this;
    }

    /**
     * The IN operator allows you to specify multiple values in a WHERE clause.
     *
     * @param string $column       The column to be used in the where in values statement.
     * @param mixed  ...$condition The condition to be used in the where in values statement.
     *
     * @return $this
     */
    public function whereInValue(string $column, ...$condition)
    {
        Validate::var($column)->isString()->isNotEmpty();
        Validate::var($condition)->isArray()->isNotEmpty();

        if (!strpos($this->_query, 'WHERE')) {
            $this->_query .= "WHERE {$column} IN (:{$column}) ";
        } else {
            $this->_query .= "AND {$column} IN (:{$column}) ";
        }

        $this->_values += [$column => $condition];

        return $this;
    }

    /**
     * The NOT IN operator allows you to specify multiple values in a WHERE clause.
     *
     * @param string $column       The column to be used in the where not in value statement.
     * @param mixed  ...$condition The condition to be used in the where not in value statement.
     *
     * @return $this
     */
    public function whereNotInValue(string $column, ...$condition)
    {
        Validate::var($column)->isString()->isNotEmpty();
        Validate::var($condition)->isArray()->isNotEmpty();

        if (!strpos($this->_query, 'WHERE')) {
            $this->_query .= "WHERE {$column} NOT IN (:{$column}) ";
        } else {
            $this->_query .= "AND {$column} NOT IN (:{$column}) ";
        }

        $this->_values += [$column => $condition];

        return $this;
    }

    /**
     * Add where or statement to the query.
     *
     * @param string $column    The column to be used in the where or statement.
     * @param mixed  ...$values The values to be used in the where or statement.
     *
     * @return $this
     */
    public function whereOr(string $column, ...$values)
    {
        Validate::var($column)->isString()->isNotEmpty();
        Validate::var($values)->isArray()->isNotEmpty();

        $query = '';
        foreach ($values as $key => $value) {
            Validate::var($key)->isScalar();
            Validate::var($value)->isScalar();

            if (!strpos($this->_query, 'WHERE')) {
                if (!strpos($query, 'OR')) {
                    $query .= "WHERE ({$column} = :" . $column . $key . " ";
                } else {
                    $query .= " OR {$column} = :" . $column . $key . " ";
                }
            }

            if (!strpos($query, 'OR')) {
                $query .= "AND ({$column} = :" . $column . $key . " OR ";
            } else {
                $query .= "{$column} = :" . $column . $key . " ";
            }

            $this->_values += [$column . $key => "{$value}"];
        }
        $query .= ') ';
        $this->_query .= $query;

        return $this;
    }

    /**
     * The IN operator allows you to specify multiple values in a WHERE clause.
     *
     * @param string $column The column to be used in the where in query statement.
     * @param string $query  The query to be used in the where in query statement.
     * @param array  $values The values to be used in the where in query statement.
     *
     * @return $this
     */
    public function whereInQuery(string $column, string $query, array $values)
    {
        Validate::var($column)->isString()->isNotEmpty();
        Validate::var($query)->isString()->isNotEmpty();
        Validate::var($values)->isArray()->isNotEmpty();

        if (!strpos($this->_query, 'WHERE')) {
            $this->_query .= "WHERE {$column} IN ({$query}) ";
        } else {
            $this->_query .= "AND {$column} IN ({$query}) ";
        }

        foreach ($values as $key => $value) {
            Validate::var($key)->isInt();
            Validate::var($values)->isScalar()->isNotEmpty();
            $this->_values[$key] = $value;
        }

        return $this;
    }

    /**
     * The BETWEEN operator selects values within a given range. The values can be numbers, text, or dates.
     * The BETWEEN operator is inclusive: begin and end values are included.
     *
     * @param string     $column      The column to be used in the where between statement.
     * @param string|int $value1      The first value to be used in the where between statement.
     * @param string|int $value2      The second value to be used in the where between statement.
     * @param bool       $orStatement Determine if the must be a hook added to the query.
     *
     * @return $this
     */
    public function whereBetween(string $column, $value1, $value2, $orStatement = false)
    {
        Validate::var($column)->isString()->isNotEmpty();
        Validate::var($value1)->isScalar()->isNotEmpty();
        Validate::var($value2)->isScalar()->isNotEmpty();

        $hook = '';
        if ($orStatement) {
            $hook = '(';
        }

        if (!strpos($this->_query, 'WHERE')) {
            $this->_query .= "WHERE {$hook} {$column} BETWEEN :{$column}1 AND :{$column}2 ";
        } else {
            $this->_query .= "AND {$hook} {$column} BETWEEN :{$column}1 AND :{$column}2 ";
        }

        $this->_values += [
            $column . '1' => $value1,
            $column . '2' => $value2
        ];

        return $this;
    }

    /**
     * The BETWEEN operator selects values within a given range. The values can be numbers, text, or dates.
     * The BETWEEN operator is inclusive: begin and end values are included.
     *
     * @param string     $column The column to be used in the where between statement.
     * @param string|int $value1 The first value to be used in the where between statement.
     * @param string|int $value2 The second value to be used in the where between statement.
     *
     * @return $this
     */
    public function whereOrBetween(string $column, $value1, $value2)
    {
        Validate::var($column)->isString()->isNotEmpty();
        Validate::var($value1)->isScalar()->isNotEmpty();
        Validate::var($value2)->isScalar()->isNotEmpty();

        $this->_query .= "OR {$column} BETWEEN :{$column}1 AND :{$column}2 )";

        $this->_values += [
            $column . '1' => $value1,
            $column . '2' => $value2
        ];

        return $this;
    }

    /**
     * The HAVING clause was added to SQL because the WHERE keyword could not be used with aggregate functions.
     *
     * @param mixed ...$conditions The condition to be used in the having statement.
     *
     * @return $this|void
     */
    public function having(...$conditions)
    {
        $conditions = implode(', ', $conditions);

        Validate::var($conditions)->isString()->isNotEmpty();
        $this->_query .= "HAVING {$conditions} ";

        return $this;
    }

    /**
     * The INSERT INTO statement is used to insert new records in a table.
     *
     * @param array $values The values to insert into the database.
     *
     * @return $this
     */
    public function insert(array $values)
    {
        Validate::var($values)->isArray()->isNotEmpty();

        $columns = array_keys($values);
        $this->_query .= "INSERT INTO " . self::$_table;
        $this->_query .= " (`" . implode('`, `', $columns) . "`)";
        $this->_query .= " VALUES (:" . implode(', :', $columns) . ") ";
        $this->_values += $values;

        return $this;
    }

    /**
     * The UPDATE statement is used to modify the existing records in a table.
     *
     * @param array $values The values to update in the database..
     *
     * @return $this
     */
    public function update(array $values)
    {
        Validate::var($values)->isArray()->isNotEmpty();
        $columns = array_keys($values);
        $lastColumn = array_key_last($values);

        $this->_query .= "UPDATE " . self::$_table . " SET ";
        foreach ($columns as $column) {
            Validate::var($column)->isString()->isNotEmpty();
            if ($lastColumn !== $column) {
                $this->_query .= "{$column} = :{$column}, ";
            } else {
                $this->_query .= "{$column} = :{$column} ";
            }
        }
        $this->_values += $values;

        return $this;
    }

    /**
     * Soft delete records from the database.
     *
     * @param string $column The column to be used in the soft delete statement.
     * @param int    $value  The values to be used in the soft delete statement.
     *
     * @return $this
     */
    public function softDelete(string $column, int $value = 1)
    {
        Validate::var($column)->isString()->isNotEmpty();
        Validate::var($value)->isInt()->isNotEmpty();
        $this->update([$column => $value]);

        return $this;
    }

    /**
     * The DELETE statement is used to delete existing records in a table.
     *
     * @return $this
     */
    public function delete()
    {
        $this->_query .= "DELETE FROM " . self::$_table . " ";

        return $this;
    }

    /**
     * Order all selected records by specified columns with a specified filter.
     *
     * @param string $filter     The filter to be used in the order by statement.
     * @param mixed  ...$columns The columns to be used in the order by statement.
     *
     * @return $this
     */
    public function orderBy(string $filter, ...$columns)
    {
        $columns = implode(', ', $columns);

        Validate::var($filter)->isString()->isNotEmpty();
        Validate::var($columns)->isString()->isNotEmpty();
        $this->_query .= "ORDER BY {$columns} {$filter} ";

        return $this;
    }

    /**
     * The GROUP BY statement is used to group the result-set by one or more columns.
     *
     * @param mixed ...$columns The columns to be used in the group by statement.
     *
     * @return $this
     */
    public function groupBy(...$columns)
    {
        $columns = implode(', ', $columns);

        Validate::var($columns)->isString()->isNotEmpty();
        $this->_query .= "GROUP BY {$columns} ";

        return $this;
    }

    /**
     * Limit the number of records that are selected from the database.
     *
     * @param int $number The maximum number of selected records.
     *
     * @return $this
     */
    public function limit(int $number = 1)
    {
        Validate::var($number)->isInt()->isNotEmpty();

        $this->_query .= "LIMIT {$number}";

        return $this;
    }

    /**
     * Execute self written queries.
     *
     * @param string $query  The query to execute.
     * @param array  $values The values to bind to the query.
     *
     * @return $this
     */
    public function query(string $query, array $values = [])
    {
        Validate::var($query)->isString()->isNotEmpty();
        Validate::var($values)->isArray();

        $this->_query = $query;
        if (!empty($this->_values) && is_array($values)) {
            $this->_values += $values;
        }

        return $this;
    }

    /**
     * Get the prepared query.
     *
     * @return string
     */
    public function getQuery()
    {
        if (!empty($this->_query)) {
            $sanitize = new Sanitize($this->_query);
            $query = $sanitize->data();

            return $query;
        }

        return '';
    }

    /**
     * Get the prepared values.
     *
     * @return array
     */
    public function getValues()
    {
        if (!empty($this->_values)) {
            return $this->_values;
        }

        return [];
    }

    /**
     * Execute the query if the query is prepared.
     *
     * @return DBProcessor
     */
    public function execute()
    {
        $sanitize = new Sanitize($this->_query);
        $query = $sanitize->data();
        $query = htmlspecialchars_decode($query);
        $values = $this->_values;

        Validate::var($query)->isString()->isNotEmpty();
        Validate::var($values)->isArray();

        return new DBProcessor($query, $values);
    }
}
