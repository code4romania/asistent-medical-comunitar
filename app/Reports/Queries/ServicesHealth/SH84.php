<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Persoană cu dizabilitate (cu sau fără certificat).
 */
class SH84 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = ['VDH_01', 'VDH_02'];

    public static bool $countBeneficiaries = true;
}
