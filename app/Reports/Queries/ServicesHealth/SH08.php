<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Hepatite cronice virale.
 */
class SH08 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VSG_HEP';

    public static bool $countBeneficiaries = true;
}
