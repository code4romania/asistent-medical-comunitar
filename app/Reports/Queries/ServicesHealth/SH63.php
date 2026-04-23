<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total servicii realizate în perioada de referință pentru Copil 0-1 ani.
 */
class SH63 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VCV_01';
}
