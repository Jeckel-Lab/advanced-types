<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 23/01/2020
 */

namespace JeckelLab\AdvancedTypes\ValueObject\Period;

use DateTimeImmutable;

/**
 * Interface PeriodInterface
 * @package JeckelLab\AdvancedTypes\ValueObject\Period
 */
interface PeriodInterface
{
    /**
     * @return DateTimeImmutable
     */
    public function start(): DateTimeImmutable;

    /**
     * @return DateTimeImmutable
     */
    public function end(): DateTimeImmutable;
}
