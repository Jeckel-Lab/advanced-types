<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 23/01/2020
 */

declare(strict_types=1);

namespace JeckelLab\AdvancedTypes\ValueObject\Period;

use DateTimeImmutable;
use DateTimeInterface;
use JeckelLab\AdvancedTypes\ValueObject\Exception\InvalidArgumentException;

/**
 * Class Month
 * @package JeckelLab\AdvancedTypes\ValueObject\Period
 * @psalm-immutable
 */
class Month implements PeriodInterface
{
    /** @var DateTimeImmutable */
    protected $start;

    /** @var DateTimeImmutable */
    protected $end;

    /** @var int */
    protected $year;

    /** @var int */
    protected $month;

    /**
     * Month constructor.
     * @param int $year
     * @param int $month
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function __construct(int $year, int $month)
    {
        $this->year = $year;
        $this->month = $month;

        $this->start = DateTimeImmutable::createFromFormat(
            'Y-m-d H:i:s',
            sprintf('%d-%d-01 00:00:00', $year, $month)
        );
        $this->end = $this->start->modify('+1 month')->modify('-1 second');
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
     * The __toString method allows a class to decide how it will react when it is converted to a string.
     *
     * @return string
     * @link https://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.tostring
     */
    public function __toString()
    {
        return sprintf('%d-%02d', $this->year, $this->month);
    }

    /**
     * @param DateTimeInterface $dateTime
     * @return static
     */
    public static function byDateTime(DateTimeInterface $dateTime): self
    {
        return new self(
            (int) $dateTime->format('Y'),
            (int) $dateTime->format('m')
        );
    }

    /**
     * @param string $value
     * @return static
     */
    public static function byString(string $value): self
    {
        $matches = [];
        if (! preg_match('/^(\d{4})-(\d{1,2})$/m', $value, $matches)) {
            throw new InvalidArgumentException('Invalid string month provided, expected YYYY-MM');
        }
        return new self((int) $matches[1], (int) $matches[2]);
    }
}
