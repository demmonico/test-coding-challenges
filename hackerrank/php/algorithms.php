<?php
/**
 * Algorithms
 *
 * @author demmonico@gmail.com
 */

function minimumAbsoluteDifference(array $arr) {
    $diff = PHP_INT_MAX;
    sort($arr);
    $n = count($arr);
    for ($i=0; $i < $n - 1; $i++) {
        $d = abs($arr[$i] - $arr[$i + 1]);
        if ($d < $diff) {
            $diff = $d;
            if ($diff === 0) {
                return $diff;
            }
        }
    }
    return $diff;
}

// timed out
//function minimumAbsoluteDifference(array $arr) {
//    $diff = PHP_INT_MAX;
//    $n = count($arr);
//    for ($i=0; $i < $n; $i++) {
//        for ($j=0; $j < $n; $j++) {
//            if ($i !== $j) {
//                $d = abs($arr[$i] - $arr[$j]);
//                if ($d < $diff) {
//                    $diff = $d;
//                }
//            }
//        }
//    }
//    return $diff;
//}
