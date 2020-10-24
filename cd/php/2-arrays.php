<?php

// arrays

// Rotate an array to the right by a given number of steps.
function cyclicRotation($array, $rotates)
{
    if (empty($array)) {
        return [];
    }

    for($r = 0; $r < $rotates; $r++) {
        $t = array_pop($array);
        array_unshift($array, $t);
    }

    return $array;
}

// Find value that occurs in odd number of elements.
function oddOccurrencesInArray($array)
{
    $stat = array_count_values($array);

    foreach($stat as $value => $i) {
        if ($i % 2 !== 0) {
            return $value;
        }
    }

    throw new LogicException();
}
