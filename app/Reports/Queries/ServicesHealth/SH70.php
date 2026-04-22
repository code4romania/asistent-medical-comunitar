<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Copil nevaccinat conform calendarului național.
 */
class SH70 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VSC_01';

    public static bool $countBeneficiaries = true;
}
