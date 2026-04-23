<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total beneficiari asistați în perioada de referință pentru Insuficiență cardiacă.
 */
class SH16 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VSG_IC';

    public static bool $countBeneficiaries = true;
}
