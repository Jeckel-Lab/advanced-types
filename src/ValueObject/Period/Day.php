<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 23/01/2020
 */

declare(strict_types=1);

namespace JeckelLab\AdvancedTypes\ValueObject\Period;

use DateTimeImmutable;
use DateTimeInterface;

/**
 * Class Day
 * @package JeckelLab\AdvancedTypes\ValueObject\Period
 * @psalm-immutable
 */
class Day implements PeriodInterface
{
    /** @var DateTimeImmutable */
    protected $start;

    /** @var DateTimeImmutable */
    protected $end;

    /** @var int */
    protected $year;

    /** @var int */
    protected $month;

    /** @var int */
    protected $day;

    /**
     * Day constructor.
     * @param int $year
     * @param int $month
     * @param int $day
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function __construct(int $year, int $month, int $day)
    {
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
        $this->start = DateTimeImmutable::createFromFormat(
            'Y-m-d H:i:s',
            sprintf('%d-%d-%d 00:00:00', $year, $month, $day)
        );
        $this->end = $this->start->modify('+1 day')->modify('-1 second');
    }

    /**
     * @return DateTimeImmutable
     */
    public function start(): DateTimeImmutable
    {
        return $this->start;
    }

    /**
     * @return DateTimeImmutable
     */
    public function end(): DateTimeImmutable
    {
        return $this->end;
    }

    /**
     * @return int
     */
    public function year(): int
    {
        return $this->year;
    }

    /**
     * @return int
     */
    public function month(): int
    {
        return $this->month;
    }

    /**
     * @return int
     */
    public function day(): int
    {
        return $this->day;
    }

    /**
     * The __toString method allows a class to decide how it will react when it is converted to a string.
     *
     * @return string
     * @link https://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.tostring
     */
    public function __toString(): string
    {
        return sprintf('%d-%02d-%02d', $this->year, $this->month, $this->day);
    }

    /**
     * @param DateTimeInterface $dateTime
     * @return static
     */
    public static function byDateTime(DateTimeInterface $dateTime): self
    {
        return new self(
            (int) $dateTime->format('Y'),
            (int) $dateTime->format('m'),
            (int) $dateTime->format('d')
        );
    }
}
