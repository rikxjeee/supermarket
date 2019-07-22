<?php

namespace spec\App\Service\Calculator;

use App\Entity\CartItem;
use App\Entity\Product;
use App\Entity\Total;
use App\Service\Calculator\SoftDrinkDiscountCalculator;
use App\Service\Provider\DiscountProvider;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SoftDrinkDiscountCalculatorSpec extends ObjectBehavior
{
    function let(DiscountProvider $discountProvider)
    {
        $this->beConstructedWith($discountProvider);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SoftDrinkDiscountCalculator::class);
    }

    function it_could_calculate_discounts_on_monday(DiscountProvider $discountProvider)
    {
        $discountProvider->isSoftDrinkDiscountApplies()->willReturn(true);

        $items = [
            $item1 = new CartItem(new Product('soft drink', Product::TYPE_SOFT_DRINK, 'Soft drink', 1, 1), 2),
        ];

        $this->getTotal($items)->shouldBeAnInstanceOf(Total::class);
        $this->getTotal($items)->getType()->shouldReturn('Soft Drink discount:');
        $this->getTotal($items)->getSum()->shouldReturn(-1.0);
    }

    function it_could_calculate_price_without_applicable_discount(DiscountProvider $discountProvider)
    {
        $discountProvider->isSoftDrinkDiscountApplies()->willReturn(false);

        $items = [
            $item1 = new CartItem(new Product('soft drink', Product::TYPE_SOFT_DRINK, 'Soft drink', 1, 1), 1),
            $item2 = new CartItem(new Product('soft drink2', Product::TYPE_SOFT_DRINK, 'Soft drink2', 1, 2), 1),
        ];

        $this->getTotal($items)->shouldBeAnInstanceOf(Total::class);
        $this->getTotal($items)->getType()->shouldReturn('Soft Drink discount:');
        $this->getTotal($items)->getSum()->shouldReturn(0.0);
    }

}
