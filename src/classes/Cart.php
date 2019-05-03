<?php

namespace Load\classes;

class Cart
{

    private $cartItems;

    private $allowedItems;

    private $notInStock;

    private $priceCalculator;

    public function __construct()
    {
        $this->priceCalculator = new PriceCalculator();

    }

    public function addItems($userInput)
    {
        foreach ($userInput as $value) {

            if (isset($this->cartItems[$value])) {
                $this->cartItems[$value]++;
            } else {
                $this->cartItems[$value] = 1;
            }



            /*   if (isset($this->allowedItems->itemList[$value])) {
                   if (isset($this->cartItems[$value])) {
                       $this->cartItems[$value]++;
                   } else {
                       $this->cartItems[$value] = 1;
                   }
               } else {
                   $this->notInStock[$value] = $value;
               }
            */
        }
        return $this->cartItems;
    }


    public function getPrice()
    {
        return $this->priceCalculator->calculatePrice($this->cartItems);
    }

    public function __toString()
    {
        $string = "Your cart: \n";
        foreach ($this->cartItems as $key => $value) {
            $string .= $key . ": " . $value . "\n";
        }
        return $string;
    }
}
