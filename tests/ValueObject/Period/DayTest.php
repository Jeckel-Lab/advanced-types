<?php

declare(strict_types=1);

namespace Tests\JeckelLab\AdvancedTypes\ValueObject\Period;

use DateTimeImmutable;
use JeckelLab\AdvancedTypes\ValueObject\Period\Day;
use PHPUnit\Framework\TestCase;

/**
 * Class DayTest
 * @package Tests\JeckelLab\AdvancedTypes\ValueObject\Period
 */
final class DayTest extends TestCase
{
    public function testGetter(): void
    {
        $day = new Day(2020, 1, 24);
        $this->assertEquals(2020, $day->year());
        $this->assertEquals(1, $day->month());
        $this->assertEquals(24, $day->day());
    }

    public function testGetStart(): void
    {
        $day = new Day(2020, 1, 24);
        $this->assertEquals('2020-01-24 00:00:00', $day->start()->format('Y-m-d H:i:s'));
    }

    public function testGetEnd(): void
    {
        $day = new Day(2020, 1, 24);
        $this->assertEquals('2020-01-24 23:59:59', $day->end()->format('Y-m-d H:i:s'));
    }

    public function testConstructByDateTime(): void
    {
        $month = Day::byDateTime(new DateTimeImmutable('2020-01-23 3:05:10'));
        $this->assertEquals(2020, $month->year());
        $this->assertEquals(1, $month->month());
        $this->assertEquals(23, $month->day());
        $this->assertEquals('2020-01-23 00:00:00', $month->start()->format('Y-m-d H:i:s'));
        $this->assertEquals('2020-01-23 23:59:59', $month->end()->format('Y-m-d H:i:s'));
    }
}
