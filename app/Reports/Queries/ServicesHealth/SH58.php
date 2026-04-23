<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Femeie însărcinată care nu este în evidența medicului de familie.
 */
class SH58 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VGR_05';

    public static bool $countBeneficiaries = true;
}
