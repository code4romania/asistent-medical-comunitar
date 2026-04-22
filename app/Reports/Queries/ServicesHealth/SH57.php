<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total servicii realizate în perioada de referință pentru Femeie însărcinată care nu este în evidența medicului de familie.
 */
class SH57 extends ServicesHealthQuery
{
    public static string $secondaryVulnerability = 'VGR_05';
}
