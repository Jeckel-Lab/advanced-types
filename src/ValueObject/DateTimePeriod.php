<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 19/12/2019
 */

namespace JeckelLab\AdvancedTypes\ValueObject;

use DateInterval;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use JeckelLab\AdvancedTypes\ValueObject\Exception\InvalidArgumentException;

/**
 * Class DateTimePeriod
 * @package JeckelLab\AdvancedTypes\ValueObject
 */
class DateTimePeriod
{
    /** @var DateTimeImmutable */
    protected $start;

    /** @var DateTimeImmutable */
    protected $end;

    /**
     * DateTimePeriod constructor.
     * @param DateTimeInterface $start
     * @param DateTimeInterface $end
     */
    public function __construct(DateTimeInterface $start, DateTimeInterface $end)
    {
        if (! self::isValid($start, $end)) {
            throw new InvalidArgumentException(sprintf(
                'Invalid start and end provided, start: %s, end: %s',
                $start->format('c'),
                $end->format('c')
            ));
        }
        if (! $start instanceof DateTimeImmutable) {
            /** @var DateTime $start */
            $start = DateTimeImmutable::createFromMutable($start);
        }
        if (! $end instanceof DateTimeImmutable) {
            /** @var DateTime $end */
            $end = DateTimeImmutable::createFromMutable($end);
        }
        $this->start = $start;
        $this->end   = $end;
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

    /**
     * @param DateTimeInterface $start
     * @param DateTimeInterface $end
     * @return bool
     */
    public static function isValid(DateTimeInterface $start, DateTimeInterface $end): bool
    {
        return $start < $end;
    }

    /**
     * @param DateTimeInterface $start
     * @param DateInterval      $interval
     * @return DateTimePeriod
     */
    public static function byStartAndInterval(DateTimeInterface $start, DateInterval $interval): DateTimePeriod
    {
        if ($start instanceof DateTime) {
            $start = DateTimeImmutable::createFromMutable($start);
        }
        return new DateTimePeriod(
            $start,
            $start->add($interval)
        );
    }

    /**
     * @param DateTimeInterface $end
     * @param DateInterval      $interval
     * @return DateTimePeriod
     */
    public static function byEndAndInterval(DateTimeInterface $end, DateInterval $interval): DateTimePeriod
    {
        if ($end instanceof DateTime) {
            $end = DateTimeImmutable::createFromMutable($end);
        }
        return new DateTimePeriod(
            $end->sub($interval),
            $end
        );
    }
}
