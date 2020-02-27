<?php

namespace spec\JeckelLab\AdvancedTypes\ValueObject;

use JeckelLab\AdvancedTypes\ValueObject\Color;
use PhpSpec\ObjectBehavior;

class ColorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedThrough([Color::class, 'byHex'], ['#FFFFFF']);
        $this->shouldHaveType(Color::class);
    }
}
