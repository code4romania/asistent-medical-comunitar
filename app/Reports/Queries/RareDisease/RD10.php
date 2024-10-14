<?php

declare(strict_types=1);

namespace App\Reports\Queries\RareDisease;

use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class RD10 extends ReportQuery
{
    /**
     * Sum beneficiari with AC-sindrom Rubinstein Taybi (VBR_RT).
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasRareDisease('VBR_RT');
    }
}
