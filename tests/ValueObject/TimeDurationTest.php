<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 30/01/2020
 */

namespace Tests\JeckelLab\AdvancedTypes\ValueObject;

use JeckelLab\AdvancedTypes\ValueObject\TimeDuration;
use PHPUnit\Framework\TestCase;

class TimeDurationTest extends TestCase
{

    public function testSub(): void
    {
        $duration = new TimeDuration(200);
        $newDuration = $duration->sub(50);
        $this->assertNotSame($duration, $newDuration);
        $this->assertEquals(200, $duration->getValue());
        $this->assertEquals(150, $newDuration->getValue());
    }

    public function testAdd(): void
    {
        $duration = new TimeDuration(200);
        $newDuration = $duration->add(50);
        $this->assertNotSame($duration, $newDuration);
        $this->assertEquals(200, $duration->getValue());
        $this->assertEquals(250, $newDuration->getValue());
    }

    public function testSubDuration(): void
    {
        $duration = new TimeDuration(200);
        $diff = new TimeDuration(50);
        $newDuration = $duration->subDuration($diff);
        $this->assertNotSame($duration, $newDuration);
        $this->assertNotSame($diff, $newDuration);
        $this->assertEquals(200, $duration->getValue());
        $this->assertEquals(50, $diff->getValue());
        $this->assertEquals(150, $newDuration->getValue());
    }

    public function testAddDuration(): void
    {
        $duration = new TimeDuration(200);
        $diff = new TimeDuration(50);
        $newDuration = $duration->addDuration($diff);
        $this->assertNotSame($duration, $newDuration);
        $this->assertNotSame($diff, $newDuration);
        $this->assertEquals(200, $duration->getValue());
        $this->assertEquals(50, $diff->getValue());
        $this->assertEquals(250, $newDuration->getValue());
    }
}
