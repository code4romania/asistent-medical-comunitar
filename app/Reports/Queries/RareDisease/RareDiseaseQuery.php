<?php

declare(strict_types=1);

namespace App\Reports\Queries\RareDisease;

use App\Reports\Queries\ReportQuery;

abstract class RareDiseaseQuery extends ReportQuery
{
    public static function aggregateByColumn(): string
    {
        return 'beneficiary_id';
    }
}
