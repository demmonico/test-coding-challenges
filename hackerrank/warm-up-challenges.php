<?php
/**
 * Warm-up Challenges
 *
 * @author demmonico@gmail.com
 */

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
