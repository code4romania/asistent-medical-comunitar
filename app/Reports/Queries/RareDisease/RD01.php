<?php

declare(strict_types=1);

namespace App\Reports\Queries\RareDisease;

use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class RD01 extends ReportQuery
{
    /**
     * Sum beneficiari with AC-trisomie 21 (sindrom Down) (VBR_DW).
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasRareDisease('VBR_DW');
    }
}
