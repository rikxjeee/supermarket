<?php

namespace Supermarket\Model\View\CartItemView;

class CartItemView
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
    private $quantity;

    public function __construct(string $name, string $price, string $quantity)
    {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'quantity' => $this->getQuantity(),
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getQuantity(): string
    {
        return $this->quantity;
    }
}
