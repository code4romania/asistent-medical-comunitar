<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Demență.
 */
class SH30 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VSG_DEM';

    public static bool $countBeneficiaries = true;
}
