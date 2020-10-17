<?php
/**
 * Test script group shuffled words
 *
 * @use `php words.php`
 *
 * @author demmonico@gmail.com
 * @date 22.11.17
 */

// init data
$words = ['hi', 'hello', 'helol', 'bye', 'eSTimate', 'asd', 'das', 'estimate', 'dsa', 'setimaet', 'etamitse', '123', '312'];

// process shuffling word and match it
$checkShuffled = function(string $word1, string $word2, bool $isCaseInsensitive = true) {
    $w1 = str_split($word1);
    $w2 = str_split($word2);
    sort($w1);
    sort($w2);
    return [] == array_udiff($w1, $w2, $isCaseInsensitive ? 'strcasecmp' : 'strcmp');
};

// process word and add it to sets
$processWord = function (string $word) use (&$results, $checkShuffled) {
    $isShuffled = false;
    foreach ($results as $k => $set) {
        foreach ($set as $setValue) {
            // for case-sensitive use $checkShuffled($word, $setValue, false)
            $isShuffled = $checkShuffled($word, $setValue);
            if ($isShuffled) {
                $results[$k][] = $word;
                break;
            }
        }
        if ($isShuffled) {
            break;
        }
    }
    if (!$isShuffled) {
        $results[][] = $word;
    }
};



// workflow
$results = [];
foreach ($words as $word) {
    $processWord($word);
}

echo 'Init: ' . PHP_EOL . implode(',', $words) . PHP_EOL . PHP_EOL;

echo 'Results: ' . PHP_EOL;
foreach ($results as $result) {
    echo implode(',', $result) . PHP_EOL;
}



// Output:
//Init:
//hi,hello,helol,bye,eSTimate,asd,das,estimate,dsa,setimaet,etamitse,123,312
//
//Results:
//hi
//hello,helol
//bye
//eSTimate,estimate,setimaet,etamitse
//asd,das,dsa
//123,312
