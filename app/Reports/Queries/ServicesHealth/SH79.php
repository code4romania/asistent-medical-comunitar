<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total servicii realizate în perioada de referință pentru Vârstnic peste 65 ani.
 */
class SH79 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VCV_06';
}
