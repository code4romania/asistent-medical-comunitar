<?php

declare(strict_types=1);

namespace App\Reports\Queries\RareDisease;

use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class RD29 extends ReportQuery
{
    /**
     * Sum beneficiari with G-scleroză laterală amiotrofică (VBR_SLA).
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasRareDisease('VBR_SLA');
    }
}
