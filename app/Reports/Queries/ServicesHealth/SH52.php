<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Lăuză adultă.
 */
class SH52 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VGR_08';

    public static bool $countBeneficiaries = true;
}
