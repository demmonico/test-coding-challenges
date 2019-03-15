<?php




//////////////////////////////////////////////
/// test samples

function findNumber($arr, $k) {
    return in_array($k, $arr) ? 'YES' : 'NO';
}

function oddNumber(int $l, int $r) {
    $response = [];

    for ($i = $l; $i <= $r; $i++) {
        if ($i % 2 !== 0) {
            $response[] = $i;
        }
    }

    return $response;
}

function sockMerchant(int $n, array $ar) {
    $colors = &$ar;
    $pairs = [];
    $odds = [];

    foreach($colors as $color) {
        if (isset($odds[$color])) {
            $pairs[] = $color;
            unset($odds[$color]);
        } else {
            $odds[$color] = 1;
        }
    }

    return count($pairs);
}

// Warm-up Challenges

function countingValleys($n, $s) {
    $valleys = 0;
    $position = 0;

    for ($i = 0; $i < $n; $i++) {
        if ($s[$i] === 'D') {
            if ($position === 0) {
                $valleys++;
            }
            $position--;
        } elseif ($s[$i] === 'U') {
            $position++;
        } else {
            throw new \Exception;
        }
    }

    return $valleys;
}

function jumpingOnClouds($c) {
    $clouds = &$c;
    $jumps = 0;
    $position = 0;

    while ($position <= count($clouds)) {
        if (isset($clouds[$position + 2]) && $clouds[$position + 2] === 0) {
            $position += 2;
        } elseif (isset($clouds[$position + 1]) && $clouds[$position + 1] === 0) {
            $position += 1;
        } else {
            break;
        }
        $jumps++;
    }

    if ($position !== count($clouds) - 1) {
        throw new \LogicException;
    }

    return $jumps;
}

const SEARCH_SYMBOL = 'a';
function repeatedString(string $substring, int $limit) {
    $symbolCounter = function($subStr) {
        return count(array_filter(str_split($subStr), function($value) {
            return $value === SEARCH_SYMBOL;
        }));
    };

    $strLength = strlen($substring);
    $fullStrCount = floor($limit / $strLength);
    $partSubStr = substr($substring, 0, $limit - $strLength * $fullStrCount);

    return $symbolCounter($substring) * $fullStrCount + $symbolCounter($partSubStr);
}

// Arrays

////////
/// much  less universal
////////
// function hourglassSum($arr) {
//     $maxSum = -PHP_INT_MAX;

//     for ($row = 1; $row < 5; $row++) {
//         for ($col = 1; $col < 5; $col++) {
//             $sum = 0;

//             for ($r = -1; $r < 2; $r++) {
//                 for ($c = -1; $c < 2; $c++) {
//                     if ($r !== 0 || $c === 0) {
//                         $sum += $arr[$row + $r][$col + $c];
//                     }
//                 }
//             }

//             if ($sum > $maxSum) {
//                 $maxSum = $sum;
//             }
//         }
//     }

//     return $maxSum;
// }

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

/////////
// timed out
/////////
// function rotLeft(array $arr, int $d) {
//     for ($i = 0; $i < $d; $i++) {
//         $arr[] = array_shift($arr);
//     }

//     return $arr;
// }

function rotLeft(array $arr, int $d) {
    return array_merge(array_slice($arr, $d), array_slice($arr, 0, $d));
}

/////////
// timed out
/////////
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

///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

// Dictionaries and Hashmaps

function checkMagazine(array $magazine, array $note) {
    foreach($note as $word) {
        if (false !== $pos = array_search($word, $magazine)) {
            unset($magazine[$pos]);
        } else {
            return 'No';
        }
    }
    return 'Yes';
}

function twoStrings(string $s1, string $s2) {
    $s1 = str_split($s1);
    $s2 = str_split($s2);
    return array_intersect($s1, $s2) === [] ? 'NO' : 'YES';
}


// Sorting

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

/////////
// timed out
/////////
//function activityNotifications(array $tr, int $frame) {
//    $mediana = function (array $a) {
//        sort($a);
//        $count = count($a);
//        $index = (int) floor($count / 2);
//        return $count & 1 ? $a[$index] : ($a[$index - 1] + $a[$index]) / 2;
//    };
//
//    $n = 0;
//    for ($day = $frame; $day < count($tr); $day++) {
//        $f = array_slice($tr, $day - $frame, $frame);
//        $m = $mediana($f);
//        if ($tr[$day] >= 2 * $m) {
//            $n++;
//        }
//    }
//
//    return $n;
//}


// Strings

function makeAnagram(string $a, string $b) {
    $a = str_split($a);
    $b = str_split($b);
    $aV = array_count_values($a);
    $bV = array_count_values($b);
    $inter = array_intersect_key($aV, $bV);
    $diffA = array_sum(array_diff_key($aV, $inter));
    $diffB = array_sum(array_diff_key($bV, $inter));
    $diff = 0;
    foreach($inter as $i => $v) {
        $diff += abs($aV[$i] - $bV[$i]);
    }
    return $diff + $diffA + $diffB;
}

function sherlockAndAnagrams(string $s) {
    $n = strlen($s);
    $hashes = [];
    for ($st = 0; $st < $n; $st++) {
        for ($e = $st; $e < $n; $e++) {
            $hash = array_fill(97, 122 - 97, 0);
            for ($j = $st; $j <= $e;  $j++) {
                $hash[ord($s[$j])]++;
            }
            $hashes[] = implode('', $hash);
        }
    }
    $freq = array_count_values($hashes);

    $k = 0;
    foreach($freq as $f) {
        $k += $f * ($f - 1) / 2;
    }
    return $k;
}


// Algorithms

/////////
// timed out
/////////
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


// Search

/////////
// timed out
/////////
//function whatFlavors(array $cost, int $money) {
//    asort($cost);
//    end($cost);
//    while (prev($cost) && $money > 0) {
//        $v = current($cost);
//        if ($v < $money && false !== $pos = array_search($money - $v, $cost)) {
//            return [min($pos + 1, key($cost) + 1), max($pos + 1, key($cost) + 1)];
//        }
//    }
//    return [];
//}

function whatFlavors(array $cost, int $money) {
    $f = array_count_values($cost);
    end($cost);
    while (prev($cost)) {
        $v = current($cost);
        $diff = $money - $v;
        if ($diff > 0 && isset($f[$diff])) {
            $pos = array_search($diff, $cost);
            return [min($pos + 1, key($cost) + 1), max($pos + 1, key($cost) + 1)];
        }
    }
    return [];
}








// SQL

select * from city c where countrycode='USA' and population > 100000;

select distinct s.city from station s where mod(id, 2) = 0;