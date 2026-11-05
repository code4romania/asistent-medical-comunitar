<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Diabet zaharat.
 */
class SH18 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VSG_DZ';

    public static bool $countBeneficiaries = true;
}
