<?php

declare(strict_types=1);

namespace App\Reports\Standard\Pregnant;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

class P08 extends Report
{
    /**
     * Sum beneficiari with Gravidă adultă (VGR_04); Neînscris la medic de familie (VSA_02).
     */
    public function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', ['VGR_04', 'VSA_02']);
            });
    }
}
