<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Tuberculoză.
 */
class SH02 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VSG_TB';

    public static bool $countBeneficiaries = true;
}
