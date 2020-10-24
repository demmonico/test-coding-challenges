<?php

// time complexity

// Count minimal number of jumps from position X to Y.
// O(1)
function frogJmp($x, $y, $jumpSize)
{
    if ($y <= $x) {
        return 0;
    }

    $distance = $y - $x;

    return (int) ceil($distance / $jumpSize);
}

// Find the missing element in a given permutation.
// 50% !!!!!
function permMissingElem($array)
{
    $size = count($array);
    $e = $size > 0 ? range(1, $size) : [];
    $diff = array_diff($e, $array);

    if ($diff === []) {
        throw new LogicException;
    }

    return array_shift($diff);
}

// Minimize the value |(A[0] + ... + A[P-1]) - (A[P] + ... + A[N-1])|
// O(N * N) - wrong
function solution($array)
{
    $diffMin = PHP_INT_MAX;
    $offset = 0;

    foreach($array as $v) {
        $offset++;
        $s1 = array_sum(array_slice($array, 0, $offset));
        $s2 = array_sum(array_slice($array, $offset));

        $diff = abs($s1 - $s2);
        if ($diff < $diffMin) {
            $diffMin = $diff;
        }

        // var_dump($s1, $s2, $diff, $diffMin, '---');
    }

    return $diffMin;
}

// O(N)
function tapeEquilibrium($array)
{
    $s1 = $array[0];
    $s2 = array_sum(array_slice($array, 1));
    $diffMin = abs($s1 - $s2);

    $size = count($array);
    for($i = 1; $i < $size - 1; $i++) {
        $s1 += $array[$i];
        $s2 -= $array[$i];

        $diff = abs($s1 - $s2);
        if ($diff < $diffMin) {
            $diffMin = $diff;
        }

        // var_dump($s1, $s2, $diff, $diffMin, '---');
    }

    return $diffMin;
}
