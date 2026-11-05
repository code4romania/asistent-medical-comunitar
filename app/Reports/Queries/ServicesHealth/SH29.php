<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total servicii realizate în perioada de referință pentru Demență.
 */
class SH29 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VSG_DEM';
}
