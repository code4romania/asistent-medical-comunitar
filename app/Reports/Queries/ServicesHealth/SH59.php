<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total servicii realizate în perioada de referință pentru Femeie însărcinată care nu a făcut controale prenatale.
 */
class SH59 extends ServicesHealthQuery
{
    public static string $secondaryVulnerability = 'VGR_06';
}
