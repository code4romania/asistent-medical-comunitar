<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Tulburări mintale și de comportament.
 */
class SH42 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VSG_TMC';

    public static bool $countBeneficiaries = true;
}
