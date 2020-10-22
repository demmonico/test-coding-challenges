<?php
/**
 * Arrays
 *
 * @author demmonico@gmail.com
 */

const WIDTH = 3;
const HEIGHT = 3;
function hourglassSum($arr) {
    $arrRows = count($arr);
    $arrCols = count($arr[0]);
    $marginHeight = (int) round((HEIGHT - 1)/2);
    $marginWidth = (int) round((WIDTH - 1)/2);
    $maxSum = -PHP_INT_MAX;

    for ($row = $marginHeight; $row < $arrRows - $marginHeight; $row++) {
        for ($col = $marginWidth; $col < $arrCols - $marginWidth; $col++) {
            $sum = 0;

            for ($r = -$marginHeight; $r <= $marginHeight; $r++) {
                for ($c = -$marginWidth; $c <= $marginWidth; $c++) {
                    if ($r !== 0 || $c === 0) {
                        $sum += $arr[$row + $r][$col + $c];
                    }
                }
            }

            if ($sum > $maxSum) {
                $maxSum = $sum;
            }
        }
    }

    return $maxSum;
}

//// much  less universal
// function hourglassSum($arr) {
//     $maxSum = -PHP_INT_MAX;
//
//     for ($row = 1; $row < 5; $row++) {
//         for ($col = 1; $col < 5; $col++) {
//             $sum = 0;
//
//             for ($r = -1; $r < 2; $r++) {
//                 for ($c = -1; $c < 2; $c++) {
//                     if ($r !== 0 || $c === 0) {
//                         $sum += $arr[$row + $r][$col + $c];
//                     }
//                 }
//             }
//
//             if ($sum > $maxSum) {
//                 $maxSum = $sum;
//             }
//         }
//     }
//
//     return $maxSum;
// }


function rotLeft(array $arr, int $d) {
    return array_merge(array_slice($arr, $d), array_slice($arr, 0, $d));
}

//// timed out
// function rotLeft(array $arr, int $d) {
//     for ($i = 0; $i < $d; $i++) {
//         $arr[] = array_shift($arr);
//     }
//
//     return $arr;
// }


function minimumBribes(array $q) {
    $bribes = 0;

    for ($i = count($q) - 1; $i >= 0; $i --) {
        if ($q[$i] - $i - 1 > 2) {
            return 'Too chaotic';
        }
        for ($j = max(0, $q[$i] - 2); $j < $i; $j++) {
            if ($q[$j] > $q[$i]) {
                $bribes++;
            }
        }
    }

    return $bribes;
}

//// timed out
//function minimumBribes(array $q) {
//    $bribes = 0;
//
//    foreach ($q as $index => $number) {
//        $delta = $number - $index - 1;
//
//        if ($delta > 0) {
//            // chaos case
//            if ($delta > 2) {
//                return 'Too chaotic';
//            }
//            // swapped forward
//            $bribes += $delta;
//        } else {
//            // swapped forvard and then backward
//            for ($i = $index + 1; $i < count($q); $i++) {
//                if ($q[$i] < $number) {
//                    $bribes += 1;
//                }
//            }
//        }
//    }
//
//    return $bribes;
//}

