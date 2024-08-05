<?php

declare(strict_types=1);

namespace App\Reports\Standard\General;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

class G20 extends Report
{
    /**
     * Sum beneficiari with Tulburări mintale şi de comportament (VSG_TMC); Adult 18-65 ani (VCV_05).
     */
    public function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', ['VSG_TMC', 'VCV_05']);
            });
    }
}
