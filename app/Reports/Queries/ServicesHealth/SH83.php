<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total servicii realizate în perioada de referință pentru Persoană cu dizabilitate (cu sau fără certificat).
 */
class SH83 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = ['VDH_01', 'VDH_02'];
}
