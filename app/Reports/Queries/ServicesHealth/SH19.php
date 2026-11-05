<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total servicii realizate în perioada de referință pentru Atac vascular cerebral.
 */
class SH19 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VSG_AVC';
}
