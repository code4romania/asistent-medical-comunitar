<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total servicii realizate în perioada de referință pentru Alt tip de afecțiune.
 */
class SH43 extends ServicesHealthQuery
{
    public static string $secondaryVulnerability = 'VSG_ALT';
}
