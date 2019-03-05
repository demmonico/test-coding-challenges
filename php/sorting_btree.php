<?php
/**
 * Test script array sorting B-tree
 *
 * @use `php sorting_btree.php`
 *
 * @author demmonico@gmail.com
 */

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
     * @param string $child
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

final class TreeSort
{
    use TimeMeasure;

    /**
     * @var BinaryNode
     */
    private $tree;
    /**
     * @var TreeVisitorInterface
     */
    private $visitor;

    /**
     * TreeSort constructor.
     * @param TreeVisitorInterface $visitor
     */
    public function __construct(TreeVisitorInterface $visitor)
    {
        $this->visitor = $visitor;
    }

    /**
     * @param array $arr
     * @return TreeVisitorInterface
     */
    public function sort(array $arr): TreeVisitorInterface
    {
        $this->beforeSort();

        // init B-tree
        foreach ($arr as $item) {
            if ($this->tree) {
                $this->tree->insert($item);
            } else {
                $this->tree = new BinaryNode($item);
            }
        }

        // traverse
        if ($this->tree) {
            $this->tree->traverse($this->visitor);
        }

        $this->afterSort(" >  {TIME} ms sorting of " . sizeof($arr) . " elements\n");

        return $this->visitor;
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



// init data
$arr = range(0, 99, rand(1, 4));
//$arr = range(0, 9999, 1);
shuffle($arr);

$visitor = new CollectTreeVisitor();
$visitor = (new TreeSort($visitor))->sort($arr);
$sorted = $visitor->getNodeValues();
//echo implode(',', $sorted) . "\n";
