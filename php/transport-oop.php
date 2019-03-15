<?php
/**
 * Test script transport's issue
 *
 * @use `php transport.php` or `php transport.php price`
 *
 * @author demmonico@gmail.com
 */

final class Ticket
{
    /**
     * @var string
     */
    private $from;
    /**
     * @var string
     */
    private $to;
    /**
     * @var int
     */
    private $price;
    /**
     * @var string
     */
    private $description;

    /**
     * Ticket constructor.
     * @param string $from
     * @param string $to
     * @param int $price
     * @param string $description
     */
    public function __construct(string $from, string $to, int $price, string $description)
    {
        $this->from = $from;
        $this->to = $to;
        $this->price = $price;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}

final class TicketFactory
{
    public function generateTickets(array $ticketsRowData): array
    {
        $tickets = [];

        foreach ($ticketsRowData as $ticketRowData) {
            $tickets[] = new Ticket(...$ticketRowData);
        }
        
        return $tickets;
    }
}

interface StrategyInterface
{
    /**
     * @param Ticket[] $variants
     * @return array
     */
    public function sort(array $variants): array;
}

final class DummyStrategy implements StrategyInterface
{
    /**
     * @param Ticket[] $variants
     * @return array
     */
    public function sort(array $variants): array
    {
        return $variants;
    }
}

final class PriceStrategy implements StrategyInterface
{
    /**
     * @param Ticket[] $variants
     * @return array
     */
    public function sort(array $variants): array
    {
        // get weights
        $weights = [];
        foreach ($variants as $index => $variant) {
            $weights[$index] = 0;

            foreach ($variant as $ticket) {
                $weights[$index] += $ticket->getPrice();
            }
        }

        // sort weights
        asort($weights);

        // sort variants
        $results = [];
        // define incremental naming
        $attempts = 0;
        $naming = function($weight, $attempts) use ($results, &$naming){
            $name = FormatHelper::money($weight) . ($attempts === 0 ? '' : " [$attempts]");
            return !isset($results[$name]) ? $name : $naming($weight, $attempts);
        };
        foreach ($weights as $index => $weight) {
            $results[$naming($weight, $attempts)] = $variants[$index];
        }

        return $results;
    }
}

final class StrategyFactory
{
    public static function getStrategy(string $type): StrategyInterface
    {
        $strategyClass = ucfirst(strtolower($type)) . 'Strategy';
        if (class_exists($strategyClass)) {
            return new $strategyClass();
        }

        return new DummyStrategy();
    }
}

interface TicketInfoFormatterInterface
{
    public function printInfo(Ticket $ticket): string;
}

final class TicketInfoFormatter implements TicketInfoFormatterInterface
{
    public function printInfo(Ticket $ticket): string
    {
        $price = FormatHelper::money($ticket->getPrice());
        
        return "From {$ticket->getFrom()} to {$ticket->getTo()}, price {$price}. {$ticket->getDescription()}";
    }
}

interface SearchInfoFormatterInterface
{
    public function printInfo(array $results): string;
}

final class SearchInfoFormatter implements SearchInfoFormatterInterface
{
    /**
     * @var TicketInfoFormatter
     */
    private $ticketInfoFormatter;

    /**
     * SearchInfoFormatter constructor.
     * @param TicketInfoFormatter $ticketInfoFormatter
     */
    public function __construct(TicketInfoFormatter $ticketInfoFormatter)
    {
        $this->ticketInfoFormatter = $ticketInfoFormatter;
    }

    public function printInfo(array $results): string
    {
        $response = '';
        $itemFormatter = $this->ticketInfoFormatter;
        $i = 0;
        
        foreach ($results as $weight => $result) {
            $weightInfo = is_int($weight) ? '' : " $weight";
            $response .= '*** Variant ' . ++$i . " *** $weightInfo ***\n";
            $response .= implode("\n", array_map(function ($ticket) use ($itemFormatter){
                /**
                 * @var $ticket Ticket
                 */
                return $itemFormatter->printInfo($ticket);
            }, $result)) . "\n\n";
        }
        
        return $response;
    }
}

final class Finder
{
    /**
     * @var StrategyInterface
     */
    private $strategy;

    /**
     * @var Ticket[] 
     */
    private $tickets = [];

    /**
     * @var array
     */
    private $results = [];

    /**
     * @var int
     */
    private $depth;

    /**
     * @var int
     */
    private $depthLimit;

    /**
     * Finder constructor.
     * @param Ticket[] $tickets
     * @param int $depthLimit
     */
    public function __construct(array $tickets, ?int $depthLimit = 10)
    {
        $this->tickets = $tickets;
        $this->depthLimit = $depthLimit;
    }

    /**
     * @param StrategyInterface $strategy
     * @return Finder
     */
    public function setStrategy(StrategyInterface $strategy): self
    {
        $this->strategy = $strategy;
        
        return $this;
    }
    
    public function search(string $from, string $to): self
    {
        $this->results = [];
        
        foreach ($this->tickets as $ticket) {
            $this->depth = 0;
            
            $stack = $this->resolve($ticket, $from, $to, []);

            if (!empty($stack)) {
                $this->results[] = $stack;
            }
        }

        return $this;
    }
    
    public function getAll(): array
    {
        return $this->strategy ? $this->strategy->sort($this->results) : $this->results;
    }

    /**
     * @param SearchInfoFormatterInterface $formatter
     * @return string
     */
    public function getAllFormatted(SearchInfoFormatterInterface $formatter): string
    {
        return $formatter->printInfo($this->getAll());
    }

    private function subSearch(string $from, string $to): array
    {
        $stack = [];
        foreach ($this->tickets as $ticket) {
            $stack = $this->resolve($ticket, $from, $to, $stack);
        }

        return $stack;
    }
    
    private function resolve(Ticket $ticket, string $from, string $to, array $stack)
    {
        // direct link
        if ($ticket->getFrom() === $from && $ticket->getTo() === $to) {
            $stack[$ticket->getFrom()] = $ticket;
        } // possible partial link
        elseif ($ticket->getFrom() === $from
            // limit is not reached
            && $this->isLimitDepthReached()
            // prevent loop
            && !isset($stack[$ticket->getFrom()])
        ) {
            // recursive search
            $furtherStack = $this->subSearch($ticket->getTo(), $to);
            if (!empty($furtherStack)) {
                $stack += [$ticket->getFrom() => $ticket] + $furtherStack;
            }
        }
        
        return $stack;
    }
    
    private function isLimitDepthReached(): bool
    {
        return ++$this->depth <= $this->depthLimit;
    }
}

final class FormatHelper
{
    const LOCALE = 'en_US';
    
    public static function money(int $number): string
    {
        setlocale(LC_MONETARY, self::LOCALE);
        
        return money_format('%n', $number ?: 0);
    }
}



// init data
$variants = [];

// abz, 
$tickets = (new TicketFactory)->generateTickets([
    ['a', 'b', 12, 'desc.AB'],
    ['a', 'c', 13, 'desc.AC'],
    ['a', 'd', 10, 'desc.AD'],
    ['c', 'e', 11, 'desc.CE'],
    ['c', 'f', 14, 'desc.CF'],
    ['f', 'c', 14, 'desc.FC'],
    ['f', 'g', 10, 'desc.FG'],
    ['g', 'f', 10, 'desc.GF'],
    ['e', 'z', 17, 'desc.EZ'],
    ['b', 'z', 20, 'desc.BZ'],
    ['d', 'z', 21, 'desc.DZ'],
]);

$strategy = StrategyFactory::getStrategy($argv[1] ?? 'dummy');
$formatter = new SearchInfoFormatter(new TicketInfoFormatter);
$variants = (new Finder($tickets))
    ->setStrategy($strategy)
    ->search('a', 'z')
    ->getAllFormatted($formatter);

print_r($variants);


/**
 * returns

*** Variant 1 ***  $31.00 ***
From a to d, price $10.00. desc.AD
From d to z, price $21.00. desc.DZ

 *** Variant 2 ***  $32.00 ***
From a to b, price $12.00. desc.AB
From b to z, price $20.00. desc.BZ

 *** Variant 3 ***  $41.00 ***
From a to c, price $13.00. desc.AC
From c to e, price $11.00. desc.CE
From e to z, price $17.00. desc.EZ

 */