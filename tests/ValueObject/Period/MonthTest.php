<?php

declare(strict_types=1);

namespace Tests\JeckelLab\AdvancedTypes\ValueObject\Period;

use JeckelLab\AdvancedTypes\ValueObject\Exception\InvalidArgumentException;
use JeckelLab\AdvancedTypes\ValueObject\Period\Month;
use PHPUnit\Framework\TestCase;

/**
 * Class MonthTest
 * @package Tests\JeckelLab\AdvancedTypes\ValueObject\Period
 */
final class MonthTest extends TestCase
{
    public function testGetEnd(): void
    {
        $month = new Month(2020, 1);
        $this->assertEquals('2020-01-31 23:59:59', $month->end()->format('Y-m-d H:i:s'));
    }

    public function testGetEndWithLeapYear(): void
    {
        $month = new Month(2020, 2);
        $this->assertEquals('2020-02-29 23:59:59', $month->end()->format('Y-m-d H:i:s'));
    }

    public function testGetEndWithNonLeapYear(): void
    {
        $month = new Month(2019, 2);
        $this->assertEquals('2019-02-28 23:59:59', $month->end()->format('Y-m-d H:i:s'));
    }

    public function testGetStart(): void
    {
        $month = new Month(2020, 1);
        $this->assertEquals('2020-01-01 00:00:00', $month->start()->format('Y-m-d H:i:s'));
    }

    public function testGetter(): void
    {
        $month = new Month(2020, 9);
        $this->assertEquals(2020, $month->year());
        $this->assertEquals(9, $month->month());
    }

    public function testConstructByDateTime(): void
    {
        $month = Month::byDateTime(new \DateTimeImmutable('2020-01-23 3:05:10'));
        $this->assertEquals(2020, $month->year());
        $this->assertEquals(1, $month->month());
        $this->assertEquals('2020-01-01 00:00:00', $month->start()->format('Y-m-d H:i:s'));
        $this->assertEquals('2020-01-31 23:59:59', $month->end()->format('Y-m-d H:i:s'));
    }

    public function testToString(): void
    {
        $this->assertEquals('2020-11', (new Month(2020, 11))->__toString());
        $this->assertEquals('2019-01', (new Month(2019, 1))->__toString());
    }

    public function testByString(): void
    {
        $this->assertEquals('2012-01', Month::byString('2012-01')->__toString());
        $this->assertEquals('2012-01', Month::byString('2012-1')->__toString());
    }

    public function testByStringErrors(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectErrorMessage('Invalid string month provided, expected YYYY-MM');

        Month::byString('foobar');
    }
}
