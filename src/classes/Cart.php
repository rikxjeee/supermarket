<?php

namespace Load\classes;

class Cart
{
    /**
     * @var CartItem[]
     */
    private $cartItems;

    private $priceCalculator;

    public function __construct()
    {
        $this->priceCalculator = new PriceCalculator();

    }

    public function addItem(Product $product): void
    {
        if (isset($this->cartItems[$product->getName()])){
            $this->cartItems[$product->getName()]->increaseQuantity();

        } else {
            $this->cartItems[$product->getName()] = new CartItem($product, 1);
        }
    }


    public function getPrice()
    {
        return $this->priceCalculator->calculateTotal($this->cartItems);
    }

    public function __toString()
    {
        $string = "Your cart: ".PHP_EOL;
        foreach ($this->cartItems as $cartItem) {
            $string .= sprintf('%s: %s', $cartItem->getProduct()->getName(), $cartItem->getQuantity()).PHP_EOL;
        }
        $string .= sprintf('You get £%s discount', $this->priceCalculator->calculateDiscount($this->cartItems)) .PHP_EOL;
        $string .= sprintf('Total: £%s', $this->priceCalculator->calculateTotal($this->cartItems)).PHP_EOL;
        return $string;
    }
}