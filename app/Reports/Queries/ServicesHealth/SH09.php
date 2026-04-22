<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

/**
 * Total servicii realizate în perioada de referință pentru Hipertensiune arterială.
 */
class SH09 extends ServicesHealthQuery
{
    public static string $secondaryVulnerability = 'VSG_HTA';
}
