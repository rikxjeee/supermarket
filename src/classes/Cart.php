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

    /**
     * @return string
     */
    public function __toString()
    {
        $string = "Your cart: ".PHP_EOL;
        foreach ($this->cartItems as $cartItem) {
            $string .= sprintf('%s: %s', $cartItem->getProduct()->getName(), $cartItem->getQuantity()).PHP_EOL;
        }
        $items = $this->priceCalculator->calculateDiscount($this->cartItems);
        if (isset($items)) {
            foreach ($items as $item) {
                $string .= sprintf('You get £%s discount for %s', $item['amount'], $item['name']) . PHP_EOL;
            }
        }
        $string .= sprintf('Total: £%s', $this->priceCalculator->calculateTotal($this->cartItems)).PHP_EOL;
        return $string;
    }

    private function hasSandwich()
    {
        foreach ($this->cartItems as $cartItem){
            if ($cartItem->getProduct()->isSandwich()) {
                return true;
            }
        }
        return false;
    }

    private function hasSoftDrink()
    {
        foreach ($this->cartItems as $cartItem){
            if ($cartItem->getProduct()->isSoftDrink()) {
                return true;
            }
        }
        return false;
    }

    private function hasCrisps()
    {
        foreach ($this->cartItems as $cartItem) {
            if ($cartItem->getProduct()->isCrisp()) {
                return true;
            }
        }
        return false;
    }
}