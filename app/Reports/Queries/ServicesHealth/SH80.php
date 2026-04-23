<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Vârstnic peste 65 ani.
 */
class SH80 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VCV_06';

    public static bool $countBeneficiaries = true;
}
