<?php

declare(strict_types=1);

namespace App\Reports\Standard\General;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

class G19 extends Report
{
    /**
     * Sum beneficiari with Consumator de substanţe psihotrope (VCR_07); Vârstnic peste 65 ani (VCV_06).
     */
    public function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', ['VCR_07', 'VCV_06']);
            });
    }
}
