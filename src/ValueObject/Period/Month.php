<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 23/01/2020
 */

declare(strict_types=1);

namespace JeckelLab\AdvancedTypes\ValueObject\Period;

use DateTimeImmutable;

/**
 * Class Month
 * @package JeckelLab\AdvancedTypes\ValueObject\Period
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
        $this->end = DateTimeImmutable::createFromFormat(
            'Y-m-d H:i:s',
            $this->start->format('Y-m-t 23:59:59')
        );
    }

    /**
     * @return DateTimeImmutable
     */
    public function getStart(): DateTimeImmutable
    {
        return $this->start;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getEnd(): DateTimeImmutable
    {
        return $this->end;
    }
}
