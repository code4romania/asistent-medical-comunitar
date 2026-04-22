<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Infecții cu transmitere sexuală.
 */
class SH06 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VSG_ITS';

    public static bool $countBeneficiaries = true;
}
