<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 20/11/2019
 */

declare(strict_types=1);

namespace JeckelLab\AdvancedTypes\ValueObject;

use JeckelLab\AdvancedTypes\ValueObject\Exception\InvalidArgumentException;

/**
 * Class Color
 * @package ValueObject
 * @psalm-immutable
 */
class Color
{
    /**
     * @var string
     */
    protected $color;

    /**
     * Color constructor.
     * @param string $color
     */
    protected function __construct(string $color)
    {
        $this->color = $color;
    }

    /**
     * @return string
     */
    public function getHex(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     * @return bool
     */
    public static function isValidHex(string $color): bool
    {
        // Remove leading # if present
        if (strpos($color, '#') === 0) {
            $color = substr($color, 1);
        }
        return (ctype_xdigit($color) && strlen($color) === 6);
    }

    /**
     * @param string $color
     * @return Color
     * @throws InvalidArgumentException
     */
    public static function byHex(string $color): Color
    {
        if (! self::isValidHex($color)) {
            throw new InvalidArgumentException(sprintf('Color %s is not a valid hex color', $color));
        }
        return new self($color);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->color;
    }
}
