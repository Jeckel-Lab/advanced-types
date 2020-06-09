<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 08/01/2020
 */

namespace Tests\JeckelLab\AdvancedTypes\ValueObject;

use Assert\InvalidArgumentException;
use JeckelLab\AdvancedTypes\ValueObject\Url;
use PHPUnit\Framework\TestCase;

/**
 * Class EmailTest
 * @package Tests\JeckelLab\AdvancedTypes\ValueObject
 */
class UrlTest extends TestCase
{
    /**
     * @dataProvider getInvalidUrls
     * @param $url
     */
    public function testConstructWithInvalidUrls($url): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Url($url);
    }

    /**
     * @return array
     */
    public function getInvalidUrls(): array
    {
        return [
            ['foobar'],
            ['']
        ];
    }

    public function testGetUrl(): void
    {
        $urlString = 'http://bar.com/foobar';
        $url = new Url($urlString);
        $this->assertEquals($urlString, $url->getUrl());
        $this->assertEquals($urlString, $url->__toString());
    }
}
