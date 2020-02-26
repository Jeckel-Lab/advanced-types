<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 26/02/2020
 */

declare(strict_types=1);

namespace JeckelLab\AdvancedTypes\ValueObject\Period;

use ArrayIterator;
use Assert\Assert;
use DateInterval;
use DatePeriod;
use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use IteratorAggregate;
use Traversable;

/**
 * Class Months
 * @package JeckelLab\AdvancedTypes\ValueObject\Period
 * @psalm-immutable
 */
class Months implements IteratorAggregate
{
    /** @var Month[] */
    private $months;

    /**
     * Months constructor.
     * @param Month[] $months
     */
    public function __construct(array $months)
    {
        Assert::thatAll($months)->isInstanceOf(Month::class);
        $this->months = $months;
    }

    /**
     * Retrieve an external iterator
     * @link https://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return ArrayIterator
     * <b>Traversable</b>
     * @throws Exception on failure.
     * @since 5.0
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->months);
    }

    /**
     * @param DateTimeInterface $start
     * @param DateTimeInterface $end
     * @return static
     * @throws Exception
     */
    public static function byDatePeriod(DateTimeInterface $start, DateTimeInterface $end): self
    {
        $months = [];
        $dateRange = new DatePeriod($start, new DateInterval('P1M'), $end);
        foreach ($dateRange as $date) {
            $months[] = Month::byDateTime($date);
        }
        return new self($months);
    }
}
