<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total servicii realizate în perioada de referință pentru Gravidă adultă.
 */
class SH49 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VGR_04';
}
