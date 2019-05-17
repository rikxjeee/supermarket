<?php


namespace Supermarket;


class Total
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var float
     */
    private $price;

    /**
     * @var int
     */
    private $remainingItems;

    /**
     * Total constructor.
     * @param string $name
     * @param float $price
     * @param $remainingItems
     */
    public function __construct(string $name, float $price, array $remainingItems = [])
    {
        $this->name = $name;
        $this->price = $price;
        $this->remainingItems = $remainingItems;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getRemainingItems()
    {
        return $this->remainingItems;
    }
}