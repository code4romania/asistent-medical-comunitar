<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total servicii realizate în perioada de referință pentru Hepatite cronice virale.
 */
class SH13 extends ServicesHealthQuery
{
    public static string $secondaryVulnerability = 'VSG_HEP';
}
