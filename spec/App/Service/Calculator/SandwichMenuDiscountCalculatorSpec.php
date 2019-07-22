<?php

namespace spec\App\Service\Calculator;

use App\Entity\CartItem;
use App\Entity\Product;
use App\Entity\Total;
use App\Service\Calculator\SandwichMenuDiscountCalculator;
use App\Service\Provider\DiscountProvider;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

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
            new CartItem(new Product('french fries', Product::TYPE_CRISP, 'Crisps', 1, 1), 1),
            new CartItem(new Product('soft drink', Product::TYPE_SOFT_DRINK, 'Soft drink', 1, 2), 1),
            new CartItem(new Product('sandwich', Product::TYPE_SANDWICH, 'Sandwich', 1, 3), 1)
        ];

        $this->getTotal($items)->shouldBeAnInstanceOf(Total::class);
        $this->getTotal($items)->getType()->shouldReturn('Sandwich menu:');
        $this->getTotal($items)->getSum()->shouldReturn(-0.0);
    }
}
