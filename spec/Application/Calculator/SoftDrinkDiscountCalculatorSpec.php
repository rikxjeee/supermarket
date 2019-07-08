<?php

namespace spec\Supermarket\Application\Calculator;

use PhpSpec\ObjectBehavior;
use Supermarket\Application\Calculator\SoftDrinkDiscountCalculator;
use Supermarket\Model\CartItem;
use Supermarket\Model\Product;
use Supermarket\Model\Total;
use Supermarket\Provider\DiscountProvider;

class SoftDrinkDiscountCalculatorSpec extends ObjectBehavior
{
    function let(DiscountProvider $discountProvider, Product $product, CartItem $cartItem)
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
            $item1 = new CartItem(new Product(1, 'coke', 1, Product::TYPE_SOFT_DRINK), 2),
            $item2 = new CartItem(new Product(2, 'coke', 1, Product::TYPE_SOFT_DRINK), 1),
        ];

        $this->getTotal($items)->shouldBeAnInstanceOf(Total::class);
        $this->getTotal($items)->getType()->shouldReturn('Soft Drink discount');
        $this->getTotal($items)->getSum()->shouldReturn(-1.0);
    }

    function it_could_calculate_price_without_applicable_discount(DiscountProvider $discountProvider)
    {
        $discountProvider->isSoftDrinkDiscountApplies()->willReturn(false);

        $items = [
            $item1 = new CartItem(new Product(1, 'coke', 1, Product::TYPE_SOFT_DRINK), 1),
            $item2 = new CartItem(new Product(2, 'coke', 1, Product::TYPE_SOFT_DRINK), 1),
        ];

        $this->getTotal($items)->shouldBeAnInstanceOf(Total::class);
        $this->getTotal($items)->getType()->shouldReturn('Soft Drink discount');
        $this->getTotal($items)->getSum()->shouldReturn(0.0);
    }
}
