<?php

namespace spec\Supermarket\Model;

use PhpSpec\ObjectBehavior;
use Supermarket\Model\Total;

class TotalSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Test type', 2);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Total::class);
    }

    function it_sould_have_a_type()
    {
        $this->getType()->shouldReturn('Test type');
    }

    function it_should_have_a_sum()
    {
        $this->getSum()->shouldReturn(2.0);
    }
}
