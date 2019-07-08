<?php

namespace spec\Supermarket\Application\Calculator;

use PhpSpec\ObjectBehavior;
use Supermarket\Application\Calculator\SandwichMenuDiscountCalculator;
use Supermarket\Model\CartItem;
use Supermarket\Model\Product;
use Supermarket\Model\Total;
use Supermarket\Provider\DiscountProvider;

class SandwichMenuDiscountCalculatorSpec extends ObjectBehavior
{
    function let(DiscountProvider $discountProvider)
    {
        $this->beConstructedWith($discountProvider);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SandwichMenuDiscountCalculator::class);
    }

    function it_can_calculate_discount_for_menus(DiscountProvider $discountProvider)
    {
        $discountProvider->getMenuItems()->willReturn([
            Product::TYPE_SANDWICH,
            Product::TYPE_SOFT_DRINK,
            Product::TYPE_CRISP
        ]);
        $discountProvider->getMenuPrice()->willReturn(3);

        $items = [
            new CartItem(new Product(1, 'french fries', 1, 'Crisps'), 1),
            new CartItem(new Product(1, 'coke', 1, 'Soft Drink'), 1),
            new CartItem(new Product(1, 'cubana', 1, 'Sandwich'), 1)
        ];

        $this->getTotal($items)->shouldBeAnInstanceOf(Total::class);
        $this->getTotal($items)->getType()->shouldReturn('Sandwich menu');
        $this->getTotal($items)->getSum()->shouldReturn(-0.0);
    }
}
