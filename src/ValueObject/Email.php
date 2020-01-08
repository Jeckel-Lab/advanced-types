<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 08/01/2020
 */

namespace JeckelLab\AdvancedTypes\ValueObject;

use Assert\Assert;

/**
 * Class Email
 * @package JeckelLab\AdvancedTypes\ValueObject
 */
class Email
{
    /** @var string */
    protected $value;

    /**
     * Email constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::that($value)->email();
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
