<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total servicii realizate în perioada de referință pentru Copil care nu este în conformitate cu standardele de dezvoltare.
 */
class SH71 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VSC_06';
}
