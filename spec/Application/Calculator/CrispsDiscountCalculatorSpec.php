<?php

namespace spec\Supermarket\Application\Calculator;

use PhpSpec\ObjectBehavior;
use Supermarket\Application\Calculator\CrispsDiscountCalculator;
use Supermarket\Model\CartItem;
use Supermarket\Model\Product;
use Supermarket\Model\Total;

class CrispsDiscountCalculatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CrispsDiscountCalculator::class);
    }

    function it_could_calculate_discounts()
    {

        $items = [
            $item1 = new CartItem(new Product(1, 'french fries', 1, 'Crisps'), 2),
            $item2 = new CartItem(new Product(2, 'chips', 2, 'Crisps'), 1),
            $item3 = new CartItem(new Product(3, 'chips2', 3, 'Crisps'), 1)
        ];

        $this->getTotal($items)->shouldBeAnInstanceOf(Total::class);
        $this->getTotal($items)->getSum()->shouldReturn(-5.0);
        $this->getTotal($items)->getType()->shouldReturn('Crisps discount');
    }
}
