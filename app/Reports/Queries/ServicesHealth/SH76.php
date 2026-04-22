<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Copil părăsit.
 */
class SH76 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VFC_09';

    public static bool $countBeneficiaries = true;
}
