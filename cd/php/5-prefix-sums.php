<?php

// prefix sums

// Compute number of integers divisible by k in range [a..b].
// O(1)
function countDiv($a, $b, $divider)
{
    $min = (int) (ceil($a / $divider) * $divider);

    // left
    $divs = 1;

    // range
    $divs += (int) floor(($b - $min) / $divider);

    // var_dump($min, ($b - $min), (int) floor(($b - $min) / $divider));

    return $divs;
}
