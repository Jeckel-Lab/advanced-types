<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 24/01/2020
 */

declare(strict_types=1);

namespace JeckelLab\AdvancedTypes\ValueObject\Period;

use DateTimeImmutable;
use DateTimeInterface;

/**
 * Class Year
 * @package JeckelLab\AdvancedTypes\ValueObject\Period
 * @psalm-immutable
 */
class Year implements PeriodInterface
{
    /** @var int */
    protected $year;

    /** @var DateTimeImmutable */
    protected $start;

    /** @var DateTimeImmutable */
    protected $end;

    /**
     * Year constructor.
     * @param int $year
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function __construct(int $year)
    {
        $this->year = $year;

        $this->start = DateTimeImmutable::createFromFormat(
            'Y-m-d H:i:s',
            sprintf('%d-01-01 00:00:00', $year)
        );
        $this->end = $this->start->modify('+1 year')->modify('-1 second');
    }

    /**
     * @return int
     */
    public function year(): int
    {
        return $this->year;
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
     * @param DateTimeInterface $dateTime
     * @return static
     */
    public static function byDateTime(DateTimeInterface $dateTime): self
    {
        return new self(
            (int) $dateTime->format('Y')
        );
    }

    /**
     * The __toString method allows a class to decide how it will react when it is converted to a string.
     *
     * @return string
     * @link https://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.tostring
     */
    public function __toString(): string
    {
        return sprintf('%d', $this->year);
    }
}
