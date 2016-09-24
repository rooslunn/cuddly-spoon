<?php

function test_task(callable $function, array $params) {
    $start_time = microtime(true);
    $result = call_user_func_array($function, $params);
    $total_time = microtime(true) - $start_time;
    echo "$function completed in $total_time secs \n";
    return $result;
}

function get_test_array($N, $min, $max) {

    $result = $haystack = [];

    for ($i = 0; $i < $N; ++$i) {
        $r = rand($min, $max);
        while (array_key_exists($r, $haystack)) {
            $r = rand($min, $max);
        }

        $result[] = $r;
        $haystack[$r] = true;
    }
    
    $rkey1 = rand(0, $N-1);
    $rkey2 = rand(0, $N-1);
    while ($rkey2 === $rkey1) {
        $rkey2 = rand(0, $N-1);
    }

    $result[$rkey2] = $result[$rkey1];

    return $result;
}

/*
 * Comlexity - O(n) 
 * Memory - O(n)
 *
 */
function solution_1(array $arr) {
    sort($arr, SORT_NUMERIC);

    $l = -1;

    foreach ($arr as $v) {
        if ($v === $l) {
            return $l;
        }
        $l = $v;
    }

    return false;
}

/*
 * Complexity - O(n)
 * Memory - O(n^2)
 *
 */
function solution_2(array $arr) {
    $semaphore = []; 
    foreach ($arr as $v) {
        if (array_key_exists($v, $semaphore)) {
            return $v;
        }
        $semaphore[$v] = true;
    }
    return false;
}

/*
 * Complexity - O(n)
 * Memory - O(n^2)
 *
 */
function solution_3(array $arr) {
    return false;
}

$N = 10**5;
$min = 0; 
$max = 2**32;

echo "Testing on $N elements \n\n";

$test_arr = test_task('get_test_array', [$N, $min, $max]);
// print_r($test_arr);

$non_unique = test_task('solution_1', [$test_arr]);
echo "Found non unique value $non_unique \n\n";

$non_unique = test_task('solution_2', [$test_arr]);
echo "Found non unique value $non_unique \n\n";

$non_unique = test_task('solution_3', [$test_arr]);
echo "Found non unique value $non_unique \n\n";
