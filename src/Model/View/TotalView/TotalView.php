<?php

namespace Supermarket\Model\View\TotalView;

class TotalView
{
    /** @var string */
    private $type;

    /** @var float */
    private $price;

    public function __construct(string $type, float $price)
    {
        $this->type = $type;
        $this->price = $price;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function toArray(): array
    {
        return [$this->getType() => $this->getPrice()];
    }
}
