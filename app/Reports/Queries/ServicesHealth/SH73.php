<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total servicii realizate în perioada de referință pentru Copil abandonat.
 */
class SH73 extends ServicesHealthQuery
{
    public static array|string $secondaryVulnerability = 'VFC_07';
}
