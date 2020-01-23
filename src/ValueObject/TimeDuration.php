<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 18/11/2019
 */

declare(strict_types=1);

namespace JeckelLab\AdvancedTypes\ValueObject;

use RuntimeException;

/**
 * Class TimeDuration
 * @psalm-immutable
 */
class TimeDuration
{
    /**
     * @var int
     */
    protected $duration;

    /**
     * TimeDuration constructor.
     * @param int $duration
     */
    public function __construct(int $duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->duration;
    }

    /**
     * @param string|null $format
     * @return string
     * @throw RuntimeException
     */
    public function format(?string $format = null): string
    {
        if (null === $format) {
            $format = $this->getOptimalFormat();
        }
        $pattern = ['/%h/', '/%m/', '/%s/', '/%M/', '/%S/'];
        $hours = floor($this->duration / 3600);
        $minutes = floor(($this->duration % 3600) / 60);
        $seconds = $this->duration % 60;

        $values  = [
            $hours,
            $minutes,
            $seconds,
            sprintf('%02d', $minutes),
            sprintf('%02d', $seconds)
        ];

        $result = preg_replace($pattern, $values, $format);
        if (is_string($result)) {
            return $result;
        }
        throw new RuntimeException('Invalid format for time duration ' . $format);
    }

    /**
     * @return string
     */
    protected function getOptimalFormat(): string
    {
        if ($this->duration > 3600) {
            return '%h:%M:%S';
        }
        if ($this->duration > 60) {
            return '%m:%S';
        }
        return '%s';
    }

    /**
     * @param int $duration
     * @return self
     */
    public function add(int $duration): self
    {
        return new self($duration + $this->duration);
    }

    /**
     * @param TimeDuration $duration
     * @return self
     */
    public function addDuration(TimeDuration $duration): self
    {
        return $this->add($duration->getValue());
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->format();
    }
}
