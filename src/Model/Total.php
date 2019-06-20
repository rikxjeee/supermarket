<?php

namespace Supermarket\Model;

class Total
{
    /** @var string */
    private $type;

    /** @var float */
    private $sum;

    /** @var array */
    private $remainingItems;

    /**
     * @param string $type
     * @param float  $sum
     * @param array  $remainingItems
     */
    public function __construct(string $type, float $sum, array $remainingItems = [])
    {
        $this->type = $type;
        $this->sum = $sum;
        $this->remainingItems = $remainingItems;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return float
     */
    public function getSum(): float
    {
        return $this->sum;
    }

    /**
     * @return array
     */
    public function getRemainingItems(): array
    {
        return $this->remainingItems;
    }
}
