<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 26/02/2020
 */

declare(strict_types=1);

namespace Tests\JeckelLab\AdvancedTypes\ValueObject\Period;

use DateTime;
use JeckelLab\AdvancedTypes\ValueObject\Period\Month;
use JeckelLab\AdvancedTypes\ValueObject\Period\Months;
use PHPUnit\Framework\TestCase;

class MonthsTest extends TestCase
{
    public function testByDatePeriod()
    {
        $start = new DateTime('2019-01-01');
        $end   = new DateTime('2019-03-02');
        $months = Months::byDatePeriod($start, $end);

        /** @var Month[] $items */
        $items = $months->getIterator()->getArrayCopy();
        $this->assertCount(3, $items);
        $this->assertEquals(2019, $items[0]->year());
        $this->assertEquals(1, $items[0]->month());
        $this->assertEquals(2019, $items[2]->year());
        $this->assertEquals(3, $items[2]->month());
    }
}
