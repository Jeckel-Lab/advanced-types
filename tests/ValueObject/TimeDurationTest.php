<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 04/06/2020
 */

declare(strict_types=1);

namespace Tests\JeckelLab\AdvancedTypes\ValueObject;

use Assert\InvalidArgumentException;
use JeckelLab\AdvancedTypes\ValueObject\TimeDuration;
use PHPUnit\Framework\TestCase;

/**
 * Class TimeDurationTest
 * @package Tests\JeckelLab\AdvancedTypes\ValueObject
 */
class TimeDurationTest extends TestCase
{
    public function testInvalidDuration(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new TimeDuration(-1);
    }

    public function testEmptyDuration(): void
    {
        $this->assertEquals(0, (new TimeDuration(0))->getValue());
        $this->assertEquals(0, (new TimeDuration())->getValue());
    }

    public function testAdd(): void
    {
        $durationA = new TimeDuration(120);
        $durationB = new TimeDuration(50);
        $durationC = $durationA->addDuration($durationB);
        $this->assertNotSame($durationA, $durationC);
        $this->assertNotSame($durationB, $durationC);
        $this->assertEquals(120, $durationA->getValue());
        $this->assertEquals(50, $durationB->getValue());
        $this->assertEquals(170, $durationC->getValue());
    }
}
