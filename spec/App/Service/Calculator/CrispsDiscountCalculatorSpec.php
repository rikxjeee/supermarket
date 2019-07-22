<?php

namespace spec\App\Service\Calculator;

use App\Entity\CartItem;
use App\Entity\Product;
use App\Entity\Total;
use App\Service\Calculator\CrispsDiscountCalculator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CrispsDiscountCalculatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CrispsDiscountCalculator::class);
    }

    function it_could_calculate_discounts()
    {

        $items = [
            $item1 = new CartItem(new Product('french fries', Product::TYPE_CRISP, 'Crisps', 1, 1), 2),
            $item2 = new CartItem(new Product('chips', Product::TYPE_CRISP, 'Crisps', 2, 2), 1),
            $item3 = new CartItem(new Product('chips2', Product::TYPE_CRISP, 'Crisps', 3, 3), 1)
        ];

        $this->getTotal($items)->shouldBeAnInstanceOf(Total::class);
        $this->getTotal($items)->getSum()->shouldReturn(-5.0);
        $this->getTotal($items)->getType()->shouldReturn('Crisps discount');
    }

}
