<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total servicii realizate în perioada de referință pentru Nou-născut.
 */
class SH61 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VCV_00';
}
