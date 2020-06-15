<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 18/11/2019
 */

declare(strict_types=1);

namespace JeckelLab\AdvancedTypes\ValueObject;

use Assert\AssertionFailedException;
use Assert\Assert;
use JeckelLab\Contract\Domain\Equality;
use JeckelLab\Contract\Domain\ValueObject\Exception\InvalidArgumentException;
use JeckelLab\Contract\Domain\ValueObject\ValueObject;
use RuntimeException;

/**
 * Class TimeDuration
 * @psalm-immutable
 * @implements ValueObject<int>
 */
class TimeDuration implements ValueObject, Equality
{
    /**
     * @var int
     */
    protected $duration;

    /**
     * TimeDuration constructor.
     * @param int $duration
     */
    public function __construct(int $duration = 0)
    {
        try {
            Assert::that($duration)->greaterOrEqualThan(0);
        } catch (AssertionFailedException $e) {
            throw new InvalidArgumentException($e->getMessage(), (int) $e->getCode(), $e);
        }
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
     * @throws RuntimeException
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
            (string) $hours,
            (string) $minutes,
            (string) $seconds,
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
     * @param int|TimeDuration $duration
     * @return self
     */
    public function add($duration): self
    {
        if ($duration instanceof self) {
            $duration = $duration->duration;
        }
        if (! is_int($duration)) {
            throw new InvalidArgumentException('Invalid argument, int or TimeDuration expected');
        }
        return new self($duration + $this->duration);
    }

    /**
     * @param int|TimeDuration $duration
     * @return self
     */
    public function sub($duration): self
    {
        if ($duration instanceof self) {
            $duration = $duration->duration;
        }
        if (! is_int($duration)) {
            throw new InvalidArgumentException('Invalid argument, int or TimeDuration expected');
        }
        return new self($this->duration - $duration);
    }

    /**
     * @param static $object
     * @return bool
     */
    public function equals($object): bool
    {
        return $object->duration === $this->duration;
    }

    /**
     * @paslm-return int
     * @return int
     */
    public function toScalar()
    {
        return $this->duration;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->format();
    }
}
