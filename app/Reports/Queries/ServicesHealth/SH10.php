<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Hipertensiune arterială.
 */
class SH10 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VSG_HTA';

    public static bool $countBeneficiaries = true;
}
