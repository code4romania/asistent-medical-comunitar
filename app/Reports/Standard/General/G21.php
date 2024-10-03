<?php

declare(strict_types=1);

namespace App\Reports\Standard\General;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

class G21 extends Report
{
    /**
     * Sum beneficiari with Consumator de substanţe psihotrope (VCR_07); Adult 18-65 ani (VCV_05) .
     */
    public function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', ['VCR_07', 'VCV_05']);
            });
    }
}