<?php
/**
 * Dictionaries and Hashmaps
 *
 * @author demmonico@gmail.com
 */

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
