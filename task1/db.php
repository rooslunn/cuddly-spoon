<?php

namespace ITSolTest;


class DB extends \mysqli {

    protected static $instance;

    public static function ready() {
        if (!self::$instance) {
            self::$instance = new self();
            $db = self::$instance;
            if ($db->connect_errno) {
                echo "Error: Failed to make a MySQL connection: \n";
                echo "Error No: {$db->connect_errno} \n";
                echo "Error: {$db->connect_error} \n";
                return false;
            }
        }
        return self::$instance;
    }

    public function __construct()
    {
        $opts = require __DIR__ . '/options.php';
        parent::__construct($opts['host'], $opts['user'], $opts['passwd'], $opts['dbname']);
    }

    public function dropNumbersTable() {
        $this->query('drop table if exists numbers');
    }

    public function createNumbersTable() {
        $create_table = 'create table numbers(
          trow tinyint unsigned not null,
          tcol tinyint unsigned not null,
          tvalue int,
          primary key (trow, tcol)
        )';
        $this->query($create_table);
    }

    public function isEmpty() {
        $result = $this->query('select count(*) as cnt from numbers');
        $count = (int) $result->fetch_assoc()['cnt'];
        return ($count === 0);
    }

    public function clearNumbers() {
        $this->query('delete from numbers');
    }

    protected function generateValuesString(array $values) {
        $result = [];
        foreach ($values as $row => $cols) {
            if (! is_array($cols)) {
                continue;
            }
            foreach ($cols as $col => $value) {
                if ((int) $value > 0) {
                    $result[] = sprintf('(%s, %s, %s)', $row, $col, $value);
                }
            }
        }
        return implode(',', $result);
    }

    public function getNumbers() {
        $result = $this->query('select * from numbers');
        return $result->fetch_all();
    }

    public function updateNumbers(array $numbers) {
        $values_sql = $this->generateValuesString($numbers);

        if (! $values_sql) {
            return false;
        }

        $insert_sql = 'insert into numbers values ' . $values_sql;
        return $this->query($insert_sql);
    }
}