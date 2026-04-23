<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Copil în plasament sau asistență maternală în condiții de risc.
 */
class SH78 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VFC_05';

    public static bool $countBeneficiaries = true;
}
