<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Femeie de vârstă fertilă.
 */
class SH56 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VGR_10';

    public static bool $countBeneficiaries = true;
}
