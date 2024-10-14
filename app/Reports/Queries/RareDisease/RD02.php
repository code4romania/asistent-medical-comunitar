<?php

declare(strict_types=1);

namespace App\Reports\Queries\RareDisease;

use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class RD02 extends ReportQuery
{
    /**
     * Sum beneficiari with AC-trisomie 18 (sindrom Edwards) (VBR_EW).
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasRareDisease('VBR_EW');
    }
}
