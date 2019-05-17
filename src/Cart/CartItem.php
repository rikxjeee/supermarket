<?php


namespace Supermarket\Cart;


use Supermarket\Product;

class CartItem
{
    /**
     * @var Product
     */
    private $product;

    /**
     * @var int
     */
    private $quantity;

    /**
     * CartItem constructor.
     * @param Product $product
     * @param int $quantity
     */
    public function __construct(Product $product, int $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function increaseQuantity()
    {
        $this->quantity++;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->product->getPrice();
    }
}