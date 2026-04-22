<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total servicii realizate în perioada de referință pentru Mamă (sau lăuză) minoră.
 */
class SH47 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = ['VGR_02', 'VGR_03'];
}
