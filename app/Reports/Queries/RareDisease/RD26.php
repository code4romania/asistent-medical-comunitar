<?php

declare(strict_types=1);

namespace App\Reports\Queries\RareDisease;

use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class RD26 extends ReportQuery
{
    /**
     * Sum beneficiari with G-distrofie musculară Duchennesi Becker (VBR_FDT).
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasRareDisease('VBR_FDT');
    }
}
