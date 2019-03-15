<?php
/**
 * Search
 *
 * @author demmonico@gmail.com
 */

function whatFlavors(array $cost, int $money) {
    $f = array_count_values($cost);
    end($cost);
    while (prev($cost)) {
        $v = current($cost);
        $diff = $money - $v;
        if ($diff > 0 && isset($f[$diff])) {
            $pos = array_search($diff, $cost);
            return [min($pos + 1, key($cost) + 1), max($pos + 1, key($cost) + 1)];
        }
    }
    return [];
}

// timed out
//function whatFlavors(array $cost, int $money) {
//    asort($cost);
//    end($cost);
//    while (prev($cost) && $money > 0) {
//        $v = current($cost);
//        if ($v < $money && false !== $pos = array_search($money - $v, $cost)) {
//            return [min($pos + 1, key($cost) + 1), max($pos + 1, key($cost) + 1)];
//        }
//    }
//    return [];
//}
