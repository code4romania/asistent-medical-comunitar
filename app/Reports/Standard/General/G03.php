<?php

declare(strict_types=1);

namespace App\Reports\Standard\General;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

class G03 extends GeneralReport
{
    /**
     * Sum beneficiari with Vârstnic peste 65 ani (VCV_06).
     */
    public function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VCV_06');
            });
    }
}
