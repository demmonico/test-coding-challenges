<?php
/**
 * Sorting
 *
 * @author demmonico@gmail.com
 */

function countSwaps(array $a) {
    $swaps = 0;

    $swap = function (int $indA, int $indB) use (&$a, &$swaps) {
        $t = $a[$indB];
        $a[$indB] = $a[$indA];
        $a[$indA] = $t;
        $swaps++;
    };

    $n = count($a);
    for ($i = 0; $i < $n; $i++) {
        for ($j = 0; $j < $n - 1; $j++) {
            // Swap adjacent elements if they are in decreasing order
            if ($a[$j] > $a[$j + 1]) {
                $swap($j, $j + 1);
            }
        }
    }

    echo "Array is sorted in $swaps swaps." . PHP_EOL;
    echo "First Element: " . reset($a) . PHP_EOL;
    echo "Last Element: " . end($a);
}

function maximumToys(array $prices, int $k) {
    sort($prices);
    $toys = 0;
    foreach ($prices as $price) {
        if ($price <= $k) {
            $k -= $price;
            $toys++;
        } else {
            break;
        }
    }
    return $toys;
}

// timed out
function activityNotifications(array $tr, int $frame) {
    $mediana = function (array $a) {
        sort($a);
        $count = count($a);
        $index = (int) floor($count / 2);
        return $count & 1 ? $a[$index] : ($a[$index - 1] + $a[$index]) / 2;
    };

    $n = 0;
    for ($day = $frame; $day < count($tr); $day++) {
        $f = array_slice($tr, $day - $frame, $frame);
        $m = $mediana($f);
        if ($tr[$day] >= 2 * $m) {
            $n++;
        }
    }

    return $n;
}
