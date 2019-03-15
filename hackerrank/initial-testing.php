<?php
/**
 * Initial testing sample
 *
 * @author demmonico@gmail.com
 */

function findNumber($arr, $k) {
    return in_array($k, $arr) ? 'YES' : 'NO';
}

function oddNumber(int $l, int $r) {
    $response = [];

    for ($i = $l; $i <= $r; $i++) {
        if ($i % 2 !== 0) {
            $response[] = $i;
        }
    }

    return $response;
}

function sockMerchant(int $n, array $ar) {
    $colors = &$ar;
    $pairs = [];
    $odds = [];

    foreach($colors as $color) {
        if (isset($odds[$color])) {
            $pairs[] = $color;
            unset($odds[$color]);
        } else {
            $odds[$color] = 1;
        }
    }

    return count($pairs);
}
