<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Atac vascular cerebral.
 */
class SH20 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VSG_AVC';

    public static bool $countBeneficiaries = true;
}
