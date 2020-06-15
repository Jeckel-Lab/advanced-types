<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 05/12/2019
 */

declare(strict_types=1);

namespace JeckelLab\AdvancedTypes\ValueObject;

use Assert\Assert;
use JeckelLab\Contract\Domain\ValueObject\ValueObject;

/**
 * Class Url
 * @package JeckelLab\AdvancedTypes\ValueObject
 * @psalm-immutable
 * @implements ValueObject<string>
 */
class Url implements ValueObject, Equality
{
    /** @var string */
    protected $url;

    /**
     * Url constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        Assert::that($url)->url();
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param static $object
     * @return bool
     */
    public function equals($object): bool
    {
        return ($object instanceof self) && ($object->url === $this->url);
    }

    /**
     * @paslm-return string
     * @return string
     */
    public function toScalar()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->url;
    }
}
