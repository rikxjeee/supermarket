<?php

namespace spec\Supermarket\Model;

use PhpSpec\ObjectBehavior;
use Supermarket\Model\Product;

class ProductSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(1, 'fries', 1, 'Crisps');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Product::class);
    }

    function it_should_have_a_name()
    {
        $this->getName()->shouldReturn('fries');
    }

    function it_should_have_a_type()
    {
        $this->getType()->shouldReturn('Crisps');
    }

    function it_should_have_an_id()
    {
        $this->getId()->shouldReturn(1);
    }

    function it_should_have_a_price()
    {
        $this->getPrice()->shouldReturn(1.0);
    }
}
