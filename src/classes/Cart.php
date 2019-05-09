<?php

namespace Load\classes;

class Cart
{
    /**
     * @var CartItem[]
     */
    private $cartItems;

    private $priceCalculator;

    private $discounts;

    public function __construct()
    {
        $this->priceCalculator = new PriceCalculator();
        $this->discounts = new DiscountCalculator();
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
        $totals = $this->priceCalculator->getTotals($this->cartItems);
        $string = file_get_contents('./template.txt');
        $items = '';
        $replace ='';
        foreach ($this->cartItems as $cartItem) {
            $items .= sprintf('| %15s | %13s | %10s |', $cartItem->getProduct()->getName(), $cartItem->getQuantity(), $cartItem->getPrice()).PHP_EOL;
        }
        $string = str_replace('%items%', $items, $string);

        $items = $this->discounts->getDiscountedItems($this->cartItems);
        $totalDiscount = 0;

        foreach ($totals as $total){
            $replace .= $total->getName() . ' : £' . $total->getPrice().PHP_EOL;
        }

        if (isset($items)) {
            foreach ($items as $item) {
               $totalDiscount += $item->getPrice();
               $replace .= sprintf(' -You get £%s discount for %s', $item->getPrice(), $item->getName()) . PHP_EOL;
            }

            $replace .= sprintf('Grand total: £%s', $this->priceCalculator->calculateTotal($this->cartItems)).PHP_EOL;

            $string = str_replace('%summary%', $replace, $string);

        }

        return $string;
    }
}