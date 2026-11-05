<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Adicții / dependențe.
 */
class SH32 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VSG_AD';

    public static bool $countBeneficiaries = true;
}
