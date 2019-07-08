<?php

namespace spec\Supermarket\Model;

use PhpSpec\Exception\Example\FailureException;
use PhpSpec\ObjectBehavior;
use Supermarket\Model\CartItem;
use Supermarket\Model\Product;

class CartItemSpec extends ObjectBehavior
{
    function let(Product $product)
    {
        $this->beConstructedWith($product, 1);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CartItem::class);
    }

    function it_should_have_a_product()
    {
        $this->getProduct()->shouldBeAnInstanceOf(Product::class);
    }

    function it_should_have_quantity()
    {
        $this->getQuantity()->shouldBeGreaterThan(0);
    }

    function getMatchers(): array
    {
        return [
            'beGreaterThan' => function ($subject, $than) {
                if ($subject === $than || $subject < $than) {
                    throw new FailureException(sprintf('Returned int should be greater than 0, git "%s".', $subject));
                }

                return true;
            }
        ];
    }
}
