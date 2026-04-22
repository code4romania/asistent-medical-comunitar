<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Mamă (sau lăuză) minoră.
 */
class SH48 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = ['VGR_02', 'VGR_03'];

    public static bool $countBeneficiaries = true;
}
