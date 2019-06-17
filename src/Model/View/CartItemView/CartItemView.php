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

    /** @var string */
    private $productUrl;

    public function __construct(string $name, string $price, string $quantity, string $productUrl)
    {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->productUrl = $productUrl;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'quantity' => $this->getQuantity(),
            'url' => $this->getProductUrl()
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

    public function getProductUrl(): string
    {
        return $this->productUrl;
    }
}
