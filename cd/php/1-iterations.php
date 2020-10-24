<?php

// iterations
// Find longest sequence of zeros in binary representation of an integer.
function finLongestBinaryZeros($n)
{
    $bin = decbin($n);
    $str = trim($bin, '0');
    $zeros = array_filter(explode('1', $str), function($i) {
        return strlen($i) > 0 ? strlen($i) : false;
    });

    if ($zeros === []) {
        return 0;
    }

    $stats = array_map(function($i) {
        return strlen($i);
    }, $zeros);

    return max($stats);
}
