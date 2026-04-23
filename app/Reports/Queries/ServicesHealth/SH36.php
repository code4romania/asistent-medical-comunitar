<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Alergii.
 */
class SH36 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VSG_AL';

    public static bool $countBeneficiaries = true;
}
