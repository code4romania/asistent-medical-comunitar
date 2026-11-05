<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Depresie.
 */
class SH28 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VSG_DEP';

    public static bool $countBeneficiaries = true;
}
