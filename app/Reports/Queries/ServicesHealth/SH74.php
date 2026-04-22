<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Copil abandonat.
 */
class SH74 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VFC_07';

    public static bool $countBeneficiaries = true;
}
