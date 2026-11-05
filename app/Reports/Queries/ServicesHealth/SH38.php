<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Boală rară.
 */
class SH38 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VSG_BR';

    public static bool $countBeneficiaries = true;
}
