<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Femeie post-avort.
 */
class SH54 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VGR_09';

    public static bool $countBeneficiaries = true;
}
