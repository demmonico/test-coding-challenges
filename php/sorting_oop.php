<?php
/**
 * Test script array sorting
 *
 * @use `php sorting_oop.php` or `php sorting_oop.php load` for load tests
 *
 * @author demmonico@gmail.com
 */

namespace Sorting;

trait SwapArrayTrait
{
    protected function swap(array &$arr, int $indA, int $indB): void
    {
        $t = $arr[$indA];
        $arr[$indA] = $arr[$indB];
        $arr[$indB] = $t;
    }
}

interface SorterInterface
{
    public function sort(array $arr): array;
}

// exchange based sorters

final class BubbleSorter implements SorterInterface
{
    use SwapArrayTrait;

    public function sort(array $arr): array
    {
        $n = sizeof($arr);

        // main loop
        for ($i = 0; $i < $n - 2; $i++) {
            $wasReplacement = false;

            // shift loop
            for ($j = 0; $j < $n - $i - 1; $j++) {
                if ($arr[$j] > $arr[$j + 1]) {
                    $this->swap($arr, $j, $j + 1);
                    $wasReplacement = true;
                }
            }

            // decrease loop count
            if (!$wasReplacement) {
                break;
            }
        }

        return $arr;
    }
}

final class ShakerSorter implements SorterInterface
{
    use SwapArrayTrait;

    public function sort(array $arr): array
    {
        $left = 0;
        $right = sizeof($arr) - 1;

        do {
            // from left to right
            for ($i = $left; $i < $right; $i++) {
                if ($arr[$i] > $arr[$i + 1]) {
                    $this->swap($arr, $i, $i + 1);
                }
            }
            $right--;
            // from right to left
            for ($i = $right; $i > $left; $i--) {
                if ($arr[$i] < $arr[$i - 1]) {
                    $this->swap($arr, $i, $i - 1);
                }
            }
            $left++;
        } while ($left <= $right);

        return $arr;
    }
}

final class QuickSorter implements SorterInterface
{
    use SwapArrayTrait;

    public function sort(array $arr): array
    {
        return $this->process($arr, 0, sizeof($arr) - 1);
    }

    private function process(array &$arr, int $left, int $right): array
    {
        $i = $left;
        $j = $right;
        $x = $arr[($left + $right) / 2];

        do {
            while ($arr[$i] < $x) $i++;
            while ($arr[$j] > $x) $j--;
            if ($i <= $j) {
                if ($arr[$i] > $arr[$j]) {
                    $this->swap($arr, $i, $j);
                }
                $i++;
                $j--;
            }
        } while ($i <= $j);

        if ($i < $right) {
            $this->process($arr, $i, $right);
        }
        if ($j > $left) {
            $this->process($arr, $left, $j);
        }

        return $arr;
    }
}

final class NativePhpQuickSorter implements SorterInterface
{
    public function sort(array $arr): array
    {
        sort($arr);
        return $arr;
    }
}

final class HeapSorter implements SorterInterface
{
    use SwapArrayTrait;

    private $heapSize;

    public function sort(array $arr): array
    {
        // make heap. max el is on top
        $this->heapSize = sizeof($arr);
        $this->buildHeap($arr);

        while ($this->heapSize > 1) {
            $this->swap($arr, 0, $this->heapSize - 1);
            $this->heapSize--;
            $this->heapify($arr, 0);
        }

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

// insertion based sorters

final class InsertionSorter implements SorterInterface
{
    public function sort(array $arr): array
    {
        $n = count($arr);

        for ($i = 1; $i <= $n - 1; $i++) {
            $t = $arr[$i];
            $j = $i - 1;
            // move to right
            while ($j >= 0 && $arr[$j] > $t) {
                $arr[$j + 1] = $arr[$j];
                $j--;
            }
            $arr[$j + 1] = $t;
        }

        return $arr;
    }
}

// tree based sorters

final class BinaryNode
{
    /**
     * @var BinaryNode
     */
    private $left;
    /**
     * @var BinaryNode
     */
    private $right;
    /**
     * @var int
     */
    private $value;

    /**
     * BinaryNode constructor.
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * Traverse tree from left to right
     *
     * @param TreeVisitorInterface $visitor
     */
    public function traverse(TreeVisitorInterface $visitor): void
    {
        if ($this->left) {
            $this->left->traverse($visitor);
        }

        $visitor->visit($this);

        if ($this->right) {
            $this->right->traverse($visitor);
        }
    }

    /**
     * @param int $value
     */
    public function insert(int $value): void
    {
        $this->insertNode(new self($value));
    }

    /**
     * @param BinaryNode $node
     * @return void
     */
    private function insertNode(BinaryNode $node): void
    {
        if ($node->getValue() < $this->value) {
            $this->setChild($node, $this->left);
        } else {
            $this->setChild($node, $this->right);
        }
    }

    /**
     * @param BinaryNode $node
     * @param BinaryNode|null $child
     */
    private function setChild(BinaryNode $node, ?BinaryNode &$child): void
    {
        if (isset($child)) {
            $child->insertNode($node);
        } else {
            $child = $node;
        }
    }
}

interface TreeVisitorInterface
{
    /**
     * @param BinaryNode $node
     * @return void
     */
    public function visit(BinaryNode $node): void;
}

final class CollectTreeVisitor implements TreeVisitorInterface
{
    private $nodeValues = [];

    /**
     * @param BinaryNode $node
     * @return void
     */
    public function visit(BinaryNode $node): void
    {
        $this->nodeValues[] = $node->getValue();
    }

    /**
     * @return array
     */
    public function getNodeValues(): array
    {
        return $this->nodeValues;
    }
}

final class BTreeSorter implements SorterInterface
{
    /**
     * @var BinaryNode
     */
    private $tree;
    /**
     * @var CollectTreeVisitor
     */
    private $visitor;

    /**
     * TreeSort constructor.
     * @param CollectTreeVisitor $visitor
     */
    public function __construct(CollectTreeVisitor $visitor)
    {
        $this->visitor = $visitor;
    }

    public function sort(array $arr): array
    {
        // init B-tree
        $this->buildTree($arr);

        // traverse
        if ($this->tree) {
            $this->tree->traverse($this->visitor);
        }

        return $this->visitor->getNodeValues();
    }

    private function buildTree(array $arr): void
    {
        foreach ($arr as $item) {
            if ($this->tree) {
                $this->tree->insert($item);
            } else {
                $this->tree = new BinaryNode($item);
            }
        }
    }
}


// sorting runner

class TestRunner
{
    const SORTED_MESSAGE = "\n{SORTER_NAME} >>>\n >  {TIME} ms sorting of {SIZE} elements\n";

    private $initArr = [];

    private $standardArr = [];

    private $verbose = false;

    public function generate(int $size, int $step): self
    {
        $this->initArr = range(0, $size, $step);
        shuffle($this->initArr);

        // prepare standard
        $this->standardArr = $this->initArr;
        sort($this->standardArr);

        // print init array
        $this->printArrayWhenVerbose($this->initArr);

        return $this;
    }

    public function setVerbose(bool $verbose): self
    {
        $this->verbose = $verbose;

        return $this;
    }

    public function run()
    {
        $sorters = [
            BubbleSorter::class,
            ShakerSorter::class,
            QuickSorter::class,
            NativePhpQuickSorter::class,
            HeapSorter::class,
            InsertionSorter::class,
            BTreeSorter::class => new CollectTreeVisitor(),
        ];

        foreach ($sorters as $key => $value) {
            // without constructor params
            if (is_int($key)) {
                $this->wrapCall(new $value, $this->initArr);
            } else {
                $this->wrapCall(new $key($value), $this->initArr);
            }
        }
    }

    private function printArrayWhenVerbose(array $arr): void
    {
        if ($this->verbose) {
            echo implode(',', $arr) . "\n";
        }
    }

    private function wrapCall(SorterInterface $sorter, array $arr)
    {
        $time = microtime(true);

        $sorted = $sorter->sort($arr);

        echo strtr(self::SORTED_MESSAGE, [
            '{SORTER_NAME}' => $this->extractName(get_class($sorter)),
            '{TIME}' => number_format((microtime(true) - $time) * 1000, 2),
            '{SIZE}' => sizeof($arr),
        ]);

        // validation
        $this->validate($sorted);

        // print sorted array
        $this->printArrayWhenVerbose($sorted);

        return $sorted;
    }

    private function extractName(string $class): string
    {
        if (false !== $namespacePos = strpos($class, '\\')) {
            $class = substr($class, $namespacePos + 1);
        }

        $class = lcfirst($class);

        $pos = strlen($class);
        while ($pos > 0) {
            $pos--;
            if ($class[$pos] === strtoupper($class[$pos])) {
                $class = substr_replace($class, strtolower(" {$class[$pos]}"), $pos, 1);
            }
        }

        return $class;
    }

    private function validate(array $arr): void
    {
        if ([] !== $diff = array_diff_assoc($this->standardArr, $arr)) {
            echo "\nthere are diff between `php standard sorting` and `validated sorting`. Please, check it\n";
            $this->printArrayWhenVerbose($diff);
            echo "`php standard sorted array` >>>\n";
            $this->printArrayWhenVerbose($this->standardArr);
            echo "`validating sorted array` >>>\n";
            $this->printArrayWhenVerbose($arr);
            die;
        }
    }
}

class CliHelper
{
    const DEFAULT_MODE = 'quick';

    public static function parseArguments(array $arguments): array
    {
        $mode = $arguments[1] ?? self::DEFAULT_MODE;
        $allowedModes = self::getModes();

        if (isset($allowedModes[$mode])) {
            return $allowedModes[$mode];
        }

        echo 'Invalid mode. Allowed are: ' . implode(',', array_keys($allowedModes)) . "\n";
        throw new \InvalidArgumentException;
    }

    private static function getModes()
    {
        return [
            'quick' => [true, 99, rand(1, 4)],
            'load' => [false, 9999, 1],
        ];
    }
}



// get arguments
[$verbose, $arraySize, $arrayStep] = CliHelper::parseArguments($argv);
// init
(new TestRunner)->setVerbose($verbose)
    ->generate($arraySize, $arrayStep)
    ->run();
