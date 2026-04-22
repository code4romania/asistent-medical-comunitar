<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total servicii realizate în perioada de referință pentru Boală pulmonară cronică constructivă.
 */
class SH25 extends ServicesHealthQuery
{
    public static string $secondaryVulnerability = 'VSG_BPOC';
}
