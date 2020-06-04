<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 19/12/2019
 */

declare(strict_types=1);

namespace JeckelLab\AdvancedTypes\ValueObject;

use DateInterval;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use JeckelLab\AdvancedTypes\ValueObject\Exception\InvalidArgumentException;

/**
 * Class DateTimePeriod
 * @package JeckelLab\AdvancedTypes\ValueObject
 * @psalm-immutable
 */
class DateTimePeriod implements ValueObject
{
    /** @var DateTimeImmutable */
    protected $start;

    /** @var DateTimeImmutable */
    protected $end;

    /**
     * DateTimePeriod constructor.
     * @param DateTimeImmutable $start
     * @param DateTimeImmutable $end
     */
    protected function __construct(DateTimeImmutable $start, DateTimeImmutable $end)
    {
        if (! self::isValid($start, $end)) {
            throw new InvalidArgumentException(sprintf(
                'Invalid start and end provided, start: %s, end: %s',
                $start->format('c'),
                $end->format('c')
            ));
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
     * @param DateTimeInterface $end
     * @return DateTimePeriod
     */
    public static function byStartAndEnd(DateTimeInterface $start, DateTimeInterface $end): DateTimePeriod
    {
        $startImmutable = self::createImmutableFromInterface($start);
        $endImmutable   = self::createImmutableFromInterface($end);
        return new self($startImmutable, $endImmutable);
    }

    /**
     * @param DateTimeInterface $start
     * @param DateInterval      $interval
     * @return DateTimePeriod
     */
    public static function byStartAndInterval(DateTimeInterface $start, DateInterval $interval): DateTimePeriod
    {
        $startImmutable = self::createImmutableFromInterface($start);
        return new DateTimePeriod(
            $startImmutable,
            $startImmutable->add($interval)
        );
    }

    /**
     * @param DateTimeInterface $end
     * @param DateInterval      $interval
     * @return DateTimePeriod
     */
    public static function byEndAndInterval(DateTimeInterface $end, DateInterval $interval): DateTimePeriod
    {
        $endImmutable = self::createImmutableFromInterface($end);
        return new DateTimePeriod(
            $endImmutable->sub($interval),
            $endImmutable
        );
    }

    /**
     * @param DateTimeInterface $dateTime
     * @return DateTimeImmutable
     * @throws InvalidArgumentException
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    protected static function createImmutableFromInterface(DateTimeInterface $dateTime): DateTimeImmutable
    {
        if ($dateTime instanceof DateTimeImmutable) {
            return $dateTime;
        }
        if ($dateTime instanceof DateTime) {
            return DateTimeImmutable::createFromMutable($dateTime);
        }
        $immutable = DateTimeImmutable::createFromFormat('c', $dateTime->format('c'));
        if (false === $immutable) {
            throw new InvalidArgumentException('Invalid datetime provided');
        }
        return $immutable;
    }
}
