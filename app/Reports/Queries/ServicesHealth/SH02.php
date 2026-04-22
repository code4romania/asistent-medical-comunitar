<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total servicii realizate în perioada de referință pentru Tuberculoză.
 */
class SH02 extends ServicesHealthQuery
{
    public static string $secondaryVulnerability = 'VSG_TB';

    public static bool $countBeneficiaries = true;
}
