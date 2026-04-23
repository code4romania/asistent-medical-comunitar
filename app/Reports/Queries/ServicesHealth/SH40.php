<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Boală infecțioasă.
 */
class SH40 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VSG_BI';

    public static bool $countBeneficiaries = true;
}
