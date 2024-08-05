<?php

declare(strict_types=1);

namespace App\Reports\Standard\RareDisease;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

class RD08 extends Report
{
    /**
     * Sum beneficiari with AC-trisomie 21 (sindrom Down) (VBR_DW).
     */
    public function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VBR_DW');
            });
    }
}
