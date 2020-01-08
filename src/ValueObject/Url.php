<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 05/12/2019
 */

namespace JeckelLab\AdvancedTypes\ValueObject;

use Assert\Assert;

/**
 * Class Url
 * @package App\Domain\ValueObject
 */
class Url
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
     * @return string
     */
    public function __toString(): string
    {
        return $this->url;
    }
}
