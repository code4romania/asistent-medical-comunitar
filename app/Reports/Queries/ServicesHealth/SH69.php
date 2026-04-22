<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total servicii realizate în perioada de referință pentru Copil nevaccinat conform calendarului național.
 */
class SH69 extends ServicesHealthQuery
{
    public static string $secondaryVulnerability = 'VSC_01';
}
