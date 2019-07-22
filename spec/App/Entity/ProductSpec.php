<?php

namespace spec\App\Entity;

use App\Entity\Product;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProductSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Fries', 'Crisps', 'Some french fries', 1, 1);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Product::class);
    }

    function it_should_have_a_name()
    {
        $this->getName()->shouldReturn('Fries');
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
