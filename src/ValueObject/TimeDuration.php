<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 18/11/2019
 */

namespace JeckelLab\Types\ValueObject;

/**
 * Class TimeDuration
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
     */
    public function format(?string $format = null): string
    {
        if (null === $format) {
            $format = $this->getOptimalFormat();
        }
        $pattern = ['/%h/', '/%m/', '/%s/'];
        $values  = [
            floor($this->duration / 3600),
            floor(($this->duration % 3600) / 60),
            floor($this->duration % 60)
        ];

        return preg_replace($pattern, $values, $format);
    }

    /**
     * @return string
     */
    protected function getOptimalFormat(): string
    {
        if ($this->duration > 3600) {
            return '%h:%m:%s';
        }
        if ($this->duration > 60) {
            return '%m:%s';
        }
        return '%s';
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->format();
    }
}
