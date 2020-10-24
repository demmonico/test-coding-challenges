<?php

// counting elements

// Find the earliest time when a frog can jump to the other side of a river.
// O(N ** 2) - 54% - performance 0
function frogRiverOne($riverSize, $leavesTimings)
{
    $currentPosition = 0;
    $availablePositions = [];
    foreach($leavesTimings as $sec => $position) {
        // if we can move forward
        if ($position > $currentPosition) {
            $availablePositions[$position] = 1;
            ksort($availablePositions);
            // shift position if available
            while(isset($availablePositions[$currentPosition + 1])) {
                $currentPosition++;
                // check for riverSize exceeding
                if ($currentPosition >= $riverSize) {
                    return $sec;
                }
            }

        }
    }

    return -1;
}

// Calculate the values of counters after applying all alternating operations: increase counter by 1; set value of all counters to current maximum.
// O(N*M) - 66% - perf 40%
function maxCounters($limit, $array)
{
    $counters = array_fill(1, $limit, 0);

    foreach($array as $i) {
        if ($i === $limit + 1) {
            $max = max($counters);
            $counters = array_fill(1, $limit, $max);
        } else {
            $counters[$i]++;
        }

        // var_dump($counters);
    }

    // var_dump($counters);

    return array_values($counters);
}

// Find the smallest positive integer that does not occur in a given sequence.
// O(N) or O(N * log(N))
function missingInteger($array)
{
    sort($array);

    $current = 0;
    foreach($array as $i) {
        if ($i <= $current) {
            continue;
        } elseif ($i === $current + 1) {
            $current = $i;
        } else {
            return $current + 1;
        }
    }

    return $current + 1;
}

// Check whether array A is a permutation.
// O(N) or O(N * log(N))
function permCheck($array)
{
    //$min = min($array);
    $e = range(1, count($array));

    return (int) ([] === array_diff($e, $array));
}
