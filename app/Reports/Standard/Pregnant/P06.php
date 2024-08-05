<?php

declare(strict_types=1);

namespace App\Reports\Standard\Pregnant;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

class P06 extends Report
{
    /**
     * Sum beneficiari with Naştere înregistrată la domiciliu (VGR_13).
     */
    public function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VGR_13');
            });
    }
}
