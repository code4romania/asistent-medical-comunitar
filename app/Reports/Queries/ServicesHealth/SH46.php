<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Minoră gravidă.
 */
class SH46 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VGR_01';

    public static bool $countBeneficiaries = true;
}
