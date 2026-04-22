<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total servicii realizate în perioada de referință pentru Mamă (sau lăuză) minoră.
 */
class SH47 extends ServicesHealthQuery
{
    public static string $secondaryVulnerability = '{{VULNERABILITY}}';
}
