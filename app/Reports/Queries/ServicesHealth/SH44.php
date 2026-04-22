<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Alt tip de afecțiune.
 */
class SH44 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VSG_ALT';

    public static bool $countBeneficiaries = true;
}
