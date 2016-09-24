<?php

namespace ITSolTest;


class Octopus
{
    const TABLE_SIZE = 10;
    const MAX_VALUE = 99999;

    protected static $instance;

    public static function ready() {
        if (! self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function isGetRequest() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    protected function isPostRequest() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function getRandoms() {
        $nrows = mt_rand(1, self::TABLE_SIZE);
        $ncols = mt_rand(1, self::TABLE_SIZE);
        $result = [];

        $i = 1;
        while ($i <= $nrows) {
            $row = mt_rand(1, self::TABLE_SIZE);
            $result[$row] = [];
            $j = 1;
            while ($j <= $ncols) {
                $col = mt_rand(1, self::TABLE_SIZE);
                $result[$row][$col] = mt_rand(1, self::MAX_VALUE);
                $j++;
            }
            $i++;
        }

        return $result;
    }

    protected function getDBNumbers() {
        $numbers = DB::ready()->getNumbers();
        return $numbers;
    }

    public function getNumbers() {

        if ($this->isGetRequest()) {
            if (DB::ready()->isEmpty()) {
                $numbers = $this->getRandoms();
            } else {
                $numbers = $this->getDBNumbers();
            }
            return $numbers;
        }

        if ($this->isPostRequest()) {
            DB::ready()->updateNumbers($_POST['number']);
            return $_POST['number'];
        }

        return [];
    }
}