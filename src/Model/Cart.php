<?php

namespace Supermarket\Model;

class Cart
{
    /**
     * @var CartItem[]
     */
    private $cartItems = [];

    public function getCart()
    {
        return $this->cartItems;
    }

    public function addToCart(Product $product)
    {
        if(isset($this->cartItems[$product->getName()])) {
            $this->cartItems[$product->getName()]->increaseQuantity();
        }else{
            $this->cartItems[$product->getName()] = new CartItem($product, 1);
        }

    }
}
