<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Infarct miocardic acut.
 */
class SH12 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VSG_IMA';

    public static bool $countBeneficiaries = true;
}
