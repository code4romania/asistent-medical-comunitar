<?php

declare(strict_types=1);

namespace App\Reports\Standard\General;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

class G14 extends Report
{
    /**
     * Sum beneficiari with Boală cronică (VSG_01); Adult 18-65 ani (VCV_05).
     */
    public function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', ['VSG_01', 'VCV_05']);
            });
    }
}
