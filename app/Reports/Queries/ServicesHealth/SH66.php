<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Copil cu greutate scăzută la naștere.
 */
class SH66 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VSC_02';

    public static bool $countBeneficiaries = true;
}
