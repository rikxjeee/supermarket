<?php

namespace spec\App\Entity;

use App\Entity\Total;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

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
