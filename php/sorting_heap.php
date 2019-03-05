<?php
/**
 * Test script array sorting heap
 *
 * @use `php sorting_heap.php`
 *
 * @author demmonico@gmail.com
 */

final class HeapSort
{
    use TimeMeasure, SwapArrayTrait;

    private $heapSize;

    /**
     * @param array $arr
     * @return array
     */
    public function sort(array $arr): array
    {
        $this->beforeSort();

        // make heap. max el is on top
        $this->heapSize = $n = sizeof($arr);
        $this->buildHeap($arr);
        while ($this->heapSize > 1) {
            $this->swap($arr, 0, $this->heapSize - 1);
            $this->heapSize--;
            $this->heapify($arr, 0);
        }

        $this->afterSort(" >  {TIME} ms sorting of {$n} elements\n");

        return $arr;
    }

    private function buildHeap(array &$arr): void
    {
        for ($i = (int) floor($this->heapSize / 2); $i > -1; $i--) {
            $this->heapify($arr, $i);
        }
    }

    private function heapify(array &$arr, int $top): void
    {
        $left = $top * 2 + 2;
        $right = $top * 2 + 1;
        $largest = $top;

        if ($left < $this->heapSize && $arr[$top] < $arr[$left]) {
            $largest = $left;
        }
        if ($right < $this->heapSize && $arr[$largest] < $arr[$right]) {
            $largest = $right;
        }
        if ($top !== $largest) {
            $this->swap($arr, $top, $largest);
            $this->heapify($arr, $largest);
        }
    }
}

trait TimeMeasure
{
    private $timestart;

    protected function beforeSort(): void
    {
        $this->timestart = microtime(true);
    }

    protected function afterSort(?string $message = "{TIME} ms\n")
    {
        $time = number_format((microtime(true) - $this->timestart) * 1000, 2);

        echo strtr($message, ['{TIME}' => $time]);
    }
}

trait SwapArrayTrait
{
    protected function swap(array &$arr, int $indA, int $indB): void
    {
        $t = $arr[$indA];
        $arr[$indA] = $arr[$indB];
        $arr[$indB] = $t;
    }
}



// init data
$arr = range(0, 99, rand(1, 4));
//$arr = range(0, 9999, 1);
shuffle($arr);
//echo implode(',', $arr) . "\n";

$sorted = (new HeapSort())->sort($arr);
//echo implode(',', $sorted) . "\n";
