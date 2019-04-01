<?php declare(strict_types=1);

namespace Receipt\Application\StatusFix;

use Receipt\Application\StatusFix\Strategy\StatusFixStrategyInterface;

class StatusFixStrategiesManager
{
    /** @var array */
    private $strategies = [];

    public function __construct(iterable $strategies)
    {
        foreach ($strategies as $strategy) {
            $this->strategies[$strategy->getName()] = $strategy;
        }
    }

    public function getStrategyByName(string $name): StatusFixStrategyInterface
    {
        if (!$this->hasStrategy($name)) {
            throw new \InvalidArgumentException(sprintf('Fix status strategy "%s" is not found', $name));
        }

        return $this->strategies[$name];
    }

    public function hasStrategy(string $name): bool
    {
        return array_key_exists($name, $this->strategies);
    }
}
