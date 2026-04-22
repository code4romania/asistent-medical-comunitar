<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Copil 0-1 ani.
 */
class SH64 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VCV_01';

    public static bool $countBeneficiaries = true;
}
