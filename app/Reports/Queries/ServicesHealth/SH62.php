<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Nou-născut.
 */
class SH62 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VCV_00';

    public static bool $countBeneficiaries = true;
}
