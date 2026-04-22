<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru HIV.
 */
class SH04 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VSG_HIV';

    public static bool $countBeneficiaries = true;
}
