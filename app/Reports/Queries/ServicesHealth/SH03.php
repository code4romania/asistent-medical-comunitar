<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total servicii realizate în perioada de referință pentru HIV.
 */
class SH03 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VSG_HIV';
}
