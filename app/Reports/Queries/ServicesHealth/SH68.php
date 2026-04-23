<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Copil născut prematur.
 */
class SH68 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VSC_10';

    public static bool $countBeneficiaries = true;
}
