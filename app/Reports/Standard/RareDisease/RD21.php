<?php

declare(strict_types=1);

namespace App\Reports\Standard\RareDisease;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

class RD21 extends Report
{
    /**
     * Sum beneficiari with G-mucopolizaharidoză tip II (sindromul Hunter) (VBR_TTU).
     */
    public function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VBR_TTU');
            });
    }
}
