<?php
/**
 * Test script array sorting
 *
 * @use `php sorting.php`
 *
 * @author demmonico@gmail.com
 */

$isVerbosalPrint = isset($argv[1]) && $argv[1] === '-v';

$cbPrintArray = function(array $arr) {
    echo implode(',', $arr) . PHP_EOL;
};

$cbSwap = function(array &$arr, int $indA, int $indB) {
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
    $cbPrintArray($arr);
}

// measure wrapper
$cbMeasure = function(callable $callback) use ($arr, $isVerbosalPrint, $cbPrintArray) {
    $time = microtime(true);
    $sorted = $callback($arr);
    $time = number_format((microtime(true) - $time) * 1000, 2);
    $size = sizeof($arr);

    echo " >  $time ms sorting of {$size} elements\n";
    if ($isVerbosalPrint) {
        $cbPrintArray($sorted);
    }

    return $sorted;
};

$cbValidate = function(array $phpSorted, array $customSorted) use ($cbPrintArray) {
    if ([] !== $diff = array_diff($phpSorted, $customSorted)) {
        echo "there are diff between `phpSorted` and `customSorted`. Please, check it\n";
        $cbPrintArray($diff);
        echo "`phpSorted` >>>\n";
        $cbPrintArray($phpSorted);
        echo "`customSorted` >>>\n";
        $cbPrintArray($customSorted);
        die;
    }
};



echo "build-in PHP sort (quicksort) >>> \n";
$cbPhpSort = function(array $arr) {
    sort($arr);
    return $arr;
};
$phpSorted = $cbMeasure($cbPhpSort);

echo "bubblesort >>> \n";
$cbBubbleSort = function(array $arr) use ($cbSwap) {
    $n = sizeof($arr);
    // main loop
    for ($i = 0; $i < $n - 2; $i++) {
        $wasReplacement = false;
        // shift loop
        for ($j = 0; $j < $n - $i - 1; $j++) {
            if ($arr[$j] > $arr[$j+1]) {
                $cbSwap($arr, $j, $j + 1);
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
$cbValidate($phpSorted, $cbMeasure($cbBubbleSort));

echo "shakersort >>> \n";
$cbShakerSort = function(array $arr) use ($cbSwap) {
    $left = 0;
    $right = sizeof($arr) - 1;

    do {
        // from left to right
        for ($i = $left; $i < $right; $i++) {
            if ($arr[$i] > $arr[$i + 1]) {
                $cbSwap($arr, $i, $i + 1);
            }
        }
        $right--;
        // from right to left
        for ($i = $right; $i > $left; $i--) {
            if ($arr[$i] < $arr[$i - 1]) {
                $cbSwap($arr, $i, $i - 1);
            }
        }
        $left++;
    } while ($left <= $right);

    return $arr;
};
$cbValidate($phpSorted, $cbMeasure($cbShakerSort));

echo "insertionsort >>> \n";
$cbInsertionSort = function(array $arr) use ($cbSwap) {
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
$cbValidate($phpSorted, $cbMeasure($cbInsertionSort));

echo "quicksort >>> \n";
$cbQuickSort = function(array $arr, ?int $left = null, ?int $right = null) use ($cbSwap, &$cbQuickSort) {
    $left = $i = $left ?? 0;
    $right = $j = $right ?? count($arr) - 1;
    $x = $arr[($left + $right) / 2];

    do {
        while ($arr[$i] < $x) $i++;
        while ($arr[$j] > $x) $j--;
        if ($i <= $j) {
            if ($arr[$i] > $arr[$j]) {
                $cbSwap($arr, $i, $j);
            }
            $i++;
            $j--;
        }
    } while ($i <= $j);

    if ($i < $right) {
        $cbQuickSort($arr, $i, $right);
    }
    if ($j > $left) {
        $cbQuickSort($arr, $left, $j);
    }

    return $arr;
};
$cbValidate($phpSorted, $cbMeasure($cbQuickSort));



// Output
//build-in PHP sort (quicksort) >>>
// >  0.05 ms sorting of 50 elements
//bubblesort >>>
// >  0.48 ms sorting of 50 elements
//shakersort >>>
// >  0.18 ms sorting of 50 elements
//insertionsort >>>
// >  0.11 ms sorting of 50 elements
//quicksort >>>
// >  0.12 ms sorting of 50 elements