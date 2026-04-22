<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total servicii realizate în perioada de referință pentru Boală infecțioasă.
 */
class SH39 extends ServicesHealthQuery
{
    public static string $secondaryVulnerability = 'VSG_BI';
}
