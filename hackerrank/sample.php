<?php
/**
 * Sample test HR with wrapper
 *
 * @author demmonico@gmail.com
 */

// sample input
$input = <<<INPUT
5
1
2
3
4
5
1
INPUT;



function test($arr, $k) {
    return in_array($k, $arr) ? 'YES' : 'NO';
}



// hackerrank caller wrapper

$arr_count = intval(trim($input));

$arr = array();

for ($i = 0; $i < $arr_count; $i++) {
    $arr_item = intval(trim($input));
    $arr[] = $arr_item;
}

$k = intval(trim($input));

$res = test($arr, $k);

echo $res . PHP_EOL;
