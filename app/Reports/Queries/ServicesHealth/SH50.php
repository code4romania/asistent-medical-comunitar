<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Gravidă adultă.
 */
class SH50 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VGR_04';

    public static bool $countBeneficiaries = true;
}
