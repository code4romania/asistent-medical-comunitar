<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total servicii realizate în perioada de referință pentru Copil cu greutate scăzută la naștere.
 */
class SH65 extends ServicesHealthQuery
{
    public static string $secondaryVulnerability = 'VSC_02';
}
