<?php

require_once __DIR__ . '/db.php';

use ITSolTest\DB;

if (DB::ready()) {
    DB::ready()->dropNumbersTable();
    DB::ready()->createNumbersTable();
}