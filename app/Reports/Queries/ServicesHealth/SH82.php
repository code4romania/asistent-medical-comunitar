<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Vârstnic care locuiește singur.
 */
class SH82 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VFA_02';

    public static bool $countBeneficiaries = true;
}
