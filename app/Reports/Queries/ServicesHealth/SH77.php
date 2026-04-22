<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total servicii realizate în perioada de referință pentru Copil în plasament sau asistență maternală în condiții de risc.
 */
class SH77 extends ServicesHealthQuery
{
    public static string $secondaryVulnerability = 'VFC_05';
}
