<?php

// fix finding smallest array element
function fixBug(&$A) {
    $ans = $A[0];
    for ($i = 1; $i < sizeof($A); $i++) {
        if ($ans > $A[$i])
            $ans = $A[$i];
    }
    return $ans;
}

// find sentence having max words
function findMaxWordSentence($text)
{
    $sentences = preg_split('/[\.\?!]/', $text);

    $wordsMaxCount = 0;
    foreach($sentences as $sentence) {
        $words = array_filter(explode(' ', trim($sentence)), function($word) {
            return '' !== trim($word);
        });

        $count = count($words);
        if ($count > $wordsMaxCount) {
            $wordsMaxCount = $count;
        }
    }

    return $wordsMaxCount;
}

// print table of numbers
function printTable($numbers, $colCountLimit)
{
    if ($numbers === []) {
        return;
    }

    $maxColumnWidth = strlen(strval(max($numbers)));
    $topLineColumn = str_pad('', $maxColumnWidth, '-');
    $cbPrintLine = function($columns) use ($topLineColumn) {
        return '+' . implode('+', array_fill(0, $columns, $topLineColumn)) . '+' . PHP_EOL;
    };

    // first line
    $firstLineColumns = min(count($numbers), $colCountLimit);
    $table = $cbPrintLine($firstLineColumns);

    // compose table
    $column = 0;
    foreach($numbers as $number) {
        // init row
        if ($column === 0) {
            $table .= '|';
        }

        $table .= str_pad($number, $maxColumnWidth, ' ', STR_PAD_LEFT) . '|';

        // EOL
        if (++$column === $colCountLimit) {
            $table .= PHP_EOL . $cbPrintLine($column);
            $column = 0;
        }
    }

    // last bottom line if line was not completed
    if ($column > 0) {
        $table .= PHP_EOL . $cbPrintLine($column);
    }

    print $table;
}
