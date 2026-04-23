<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Steato-hepatite.
 */
class SH22 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VSG_SH';

    public static bool $countBeneficiaries = true;
}
