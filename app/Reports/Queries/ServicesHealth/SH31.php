<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total servicii realizate în perioada de referință pentru Adicții / dependențe.
 */
class SH31 extends ServicesHealthQuery
{
    public static string $secondaryVulnerability = 'VSG_AD';
}
