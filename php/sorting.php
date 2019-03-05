<?php
/**
 * Test script array sorting
 *
 * @use `php sorting.php`
 *
 * @author demmonico@gmail.com
 */

$isVerbosalPrint = isset($argv[1]) && $argv[1] === '-v';

$printArr = function(array $arr) {
    echo implode(',', $arr) . "\n";
};

$swap = function(array &$arr, int $indA, int $indB) {
    // more LoC but faster
    $t = $arr[$indA];
    $arr[$indA] = $arr[$indB];
    $arr[$indB] = $t;
    // nice but slower
//    [$arr[$indA], $arr[$indB]] = [$arr[$indB], $arr[$indA]];
};

// init with random shuffled array
$arr = range(0, 99, rand(1, 4));
//$arr = range(0, 9999, 1);
shuffle($arr);
if ($isVerbosalPrint) {
    echo "initial array\n";
    $printArr($arr);
}

// measure wrapper
$measure = function(callable $callback) use ($arr, $isVerbosalPrint, $printArr) {
    $time = microtime(true);
    $sorted = $callback($arr);
    $time = number_format((microtime(true) - $time) * 1000, 2);
    $size = sizeof($arr);

    echo " >  $time ms sorting of {$size} elements\n";
    if ($isVerbosalPrint) {
        $printArr($sorted);
    }

    return $sorted;
};

$validate = function(array $phpSorted, array $customSorted) use ($printArr) {
    if ([] !== $diff = array_diff($phpSorted, $customSorted)) {
        echo "there are diff between `phpSorted` and `customSorted`. Please, check it\n";
        $printArr($diff);
        echo "`phpSorted` >>>\n";
        $printArr($phpSorted);
        echo "`customSorted` >>>\n";
        $printArr($customSorted);
        die;
    }
};



echo "build-in PHP sort (quicksort) >>> \n";
$phpSort = function(array $arr) {
    sort($arr);
    return $arr;
};
$phpSorted = $measure($phpSort);

echo "bubblesort >>> \n";
$bubbleSort = function(array $arr) use ($swap) {
    $n = sizeof($arr);
    // main loop
    for ($i = 0; $i < $n - 2; $i++) {
        $wasReplacement = false;
        // shift loop
        for ($j = 0; $j < $n - $i - 1; $j++) {
            if ($arr[$j] > $arr[$j+1]) {
                $swap($arr, $j, $j + 1);
                $wasReplacement = true;
            }
        }
        // decrease loop count
        if (!$wasReplacement) {
            break;
        }
    }

    return $arr;
};
$validate($phpSorted, $measure($bubbleSort));

echo "shakersort >>> \n";
$shakerSort = function(array $arr) use ($swap) {
    $left = 0;
    $right = sizeof($arr) - 1;

    do {
        // from left to right
        for ($i = $left; $i < $right; $i++) {
            if ($arr[$i] > $arr[$i + 1]) {
                $swap($arr, $i, $i + 1);
            }
        }
        $right--;
        // from right to left
        for ($i = $right; $i > $left; $i--) {
            if ($arr[$i] < $arr[$i - 1]) {
                $swap($arr, $i, $i - 1);
            }
        }
        $left++;
    } while ($left <= $right);

    return $arr;
};
$validate($phpSorted, $measure($shakerSort));

echo "insertionsort >>> \n";
$insertionSort = function(array $arr) use ($swap) {
    $n = sizeof($arr);

    for ($i = 2; $i <= $n; $i++) {
        $t = $arr[$i];
        $j = $i;
        // move to right
        while ($j > 1 && $arr[$j - 1] > $t) {
            $arr[$j] = $arr[$j - 1];
            $j--;
        }
        $arr[$j] = $t;
    }

    return $arr;
};
$validate($phpSorted, $measure($insertionSort));

echo "quicksort >>> \n";
$quickSort = function(array $arr, ?int $left = null, ?int $right = null) use ($swap, &$quickSort) {
    $left = $i = $left ?? 0;
    $right = $j = $right ?? count($arr) - 1;
    $x = $arr[($left + $right) / 2];

    do {
        while ($arr[$i] < $x) $i++;
        while ($arr[$j] > $x) $j--;
        if ($i <= $j) {
            if ($arr[$i] > $arr[$j]) {
                $swap($arr, $i, $j);
            }
            $i++;
            $j--;
        }
    } while ($i <= $j);

    if ($i < $right) {
        $quickSort($arr, $i, $right);
    }
    if ($j > $left) {
        $quickSort($arr, $left, $j);
    }

    return $arr;
};
$validate($phpSorted, $measure($quickSort));
