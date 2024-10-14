<?php

declare(strict_types=1);

namespace App\Reports\Queries\RareDisease;

use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class RD05 extends ReportQuery
{
    /**
     * Sum beneficiari with AC-sindrom Lejeune (cri du chat) (VBR_LJ).
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasRareDisease('VBR_LJ');
    }
}
