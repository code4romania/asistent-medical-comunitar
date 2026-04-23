<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Afecțiuni oncologice.
 */
class SH34 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VSG_ONC';

    public static bool $countBeneficiaries = true;
}
