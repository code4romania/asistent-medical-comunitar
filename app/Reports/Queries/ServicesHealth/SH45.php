<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total servicii realizate în perioada de referință pentru Minoră gravidă.
 */
class SH45 extends ServicesHealthQuery
{
    public static string $secondaryVulnerability = 'VGR_01';
}
