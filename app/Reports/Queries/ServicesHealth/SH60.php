<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Femeie însărcinată care nu a făcut controale prenatale.
 */
class SH60 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VGR_06';

    public static bool $countBeneficiaries = true;
}
