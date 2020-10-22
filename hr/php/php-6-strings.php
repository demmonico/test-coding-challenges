<?php
/**
 * Strings
 *
 * @author demmonico@gmail.com
 */

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
