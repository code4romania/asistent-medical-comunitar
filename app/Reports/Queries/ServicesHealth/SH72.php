<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Copil care nu este în conformitate cu standardele de dezvoltare.
 */
class SH72 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VSC_06';

    public static bool $countBeneficiaries = true;
}
