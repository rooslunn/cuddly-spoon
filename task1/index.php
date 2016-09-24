<?php

require_once __DIR__ . '/bootstrap.php';

use ITSolTest\DB;
use ITSolTest\Octopus;

DB::ready();
Octopus::ready();

$numbers = Octopus::ready()->getNumbers();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>100x100</title>
    <style>
        div.table {
            float:left;
            width: 100%;
            overflow: auto;
            white-space: nowrap;
        }
        input[type='text'] {
            width: 80px;
        }
    </style>
</head>
<body>

<form action="/" method="post">
    <div class="table">
        <?php foreach (range(1, Octopus::TABLE_SIZE) as $row): ?>
            <div class="row">
                <?php foreach (range(1, Octopus::TABLE_SIZE) as $col): ?>
                    <?php
                        $value = '';
                        if (array_key_exists($row, $numbers) && array_key_exists($col, $numbers[$row])) {
                            $value = $numbers[$row][$col];
                        }
                    ?>
                    <input type="text" name="<?= sprintf('number[%s][%s]', $row, $col) ?>" value="<?= $value ?>">
                <?php endforeach ?>
            </div>
        <?php endforeach ?>
    </div>
    <hr>
    <input type="submit">
</form>

</body>
</html>
