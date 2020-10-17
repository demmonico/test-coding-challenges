<?php
/**
 * Test script group shuffled words
 * more productive then no-OOP
 *
 * @use `php words_oop.php`
 *
 * @author demmonico@gmail.com
 * @date 17.10.20
 */

final class ShuffleFinder
{
    private $compareCaseSensitive;

    public function __construct(bool $isCaseSensitive = true)
    {
        $this->compareCaseSensitive = $isCaseSensitive;
    }

    public function process(array $words)
    {
        // add index
        $words = $this->indexise($words);

        // normalise
        $normalised = $this->normalise($words, $this->compareCaseSensitive);

        // find doubles
        $doubles = array_count_values($normalised);

        // group doubled words
        $results = [];
        foreach ($doubles as $double => $count) {
            if ($count > 1) {
                $indexes = array_filter($normalised, function($v) use ($double) {
                    return strcmp($double, $v) === 0;
                });
                $results[] = array_intersect_key($words, $indexes);
            } else {
                $index = array_search($double, $normalised);
                $results[] = [$words[$index]];
            }
        }

        return array_values($results);
    }

    private function indexise(array $words): array
    {
        foreach ($words as $index => $word) {
            $words[microtime() . random_int(8, 16)] = $word;
            unset($words[$index]);
        }

        return $words;
    }

    private function normalise(array $words, bool $isCaseSensitive = true): array
    {
        foreach ($words as &$word) {
            if (!$isCaseSensitive) {
                $word = strtolower($word);
            }
            $letters = str_split($word);
            sort($letters);
            $word = implode('', $letters);
        }

        return $words;
    }
}



// init data
$words = ['hi', 'hello', 'helol', 'bye', 'eSTimate', 'asd', 'das', 'estimate', 'dsa', 'setimaet', 'etamitse', '123', '312'];
echo 'Init: ' . PHP_EOL . implode(',', $words) . PHP_EOL . PHP_EOL;

echo 'Results: ' . PHP_EOL;
$results = (new ShuffleFinder(false))->process($words);
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
