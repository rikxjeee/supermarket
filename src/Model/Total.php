<?php

namespace Supermarket\Model;

class Total
{
    /** @var string */
    private $type;

    /** @var float */
    private $sum;

    /** @var CartItem[] */
    private $remainingItems;

    public function __construct(string $type, float $sum, array $remainingItems = [])
    {
        $this->type = $type;
        $this->sum = $sum;
        $this->remainingItems = $remainingItems;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getSum(): float
    {
        return $this->sum;
    }

    /**
     * @return CartItem[]
     */
    public function getRemainingItems(): array
    {
        return $this->remainingItems;
    }
}
