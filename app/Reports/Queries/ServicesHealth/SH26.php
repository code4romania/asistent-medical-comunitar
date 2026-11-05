<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Boală pulmonară cronică constructivă.
 */
class SH26 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VSG_BPOC';

    public static bool $countBeneficiaries = true;
}
