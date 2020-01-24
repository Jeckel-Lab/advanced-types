<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 24/01/2020
 */

namespace Tests\JeckelLab\AdvancedTypes\ValueObject\Period;

use DateTimeImmutable;
use JeckelLab\AdvancedTypes\ValueObject\Period\Year;
use PHPUnit\Framework\TestCase;

class YearTest extends TestCase
{
    public function testGetter(): void
    {
        $year = new Year(2020);
        $this->assertEquals(2020, $year->year());
    }

    public function testGetStart(): void
    {
        $year = new Year(2020);
        $this->assertEquals('2020-01-01 00:00:00', $year->start()->format('Y-m-d H:i:s'));
    }

    public function testGetEnd(): void
    {
        $year = new Year(2020);
        $this->assertEquals('2020-12-31 23:59:59', $year->end()->format('Y-m-d H:i:s'));
    }

    public function testConstructByDateTime(): void
    {
        $month = Year::byDateTime(new DateTimeImmutable('2020-01-23 3:05:10'));
        $this->assertEquals(2020, $month->year());
        $this->assertEquals('2020-01-01 00:00:00', $month->start()->format('Y-m-d H:i:s'));
        $this->assertEquals('2020-12-31 23:59:59', $month->end()->format('Y-m-d H:i:s'));
    }
}
