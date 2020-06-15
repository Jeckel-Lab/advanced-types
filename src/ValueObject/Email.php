<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 08/01/2020
 */

declare(strict_types=1);

namespace JeckelLab\AdvancedTypes\ValueObject;

use Assert\Assert;
use Assert\AssertionFailedException;
use JeckelLab\Contract\Domain\Equality;
use JeckelLab\Contract\Domain\ValueObject\Exception\InvalidArgumentException;
use JeckelLab\Contract\Domain\ValueObject\ValueObject;

/**
 * Class Email
 * @package JeckelLab\AdvancedTypes\emailObject
 * @psalm-immutable
 * @implements ValueObject<string>
 */
class Email implements ValueObject, Equality
{
    /** @var string */
    protected $email;

    /**
     * Email constructor.
     * @param string $email
     */
    public function __construct(string $email)
    {
        try {
            Assert::that($email)->email();
        } catch (AssertionFailedException $e) {
            throw new InvalidArgumentException($e->getMessage(), (int) $e->getCode(), $e);
        }
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param static $object
     * @return bool
     */
    public function equals($object): bool
    {
        return $object->email === $this->email;
    }

    /**
     * @paslm-return string
     * @return string
     */
    public function toScalar()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->email;
    }
}
