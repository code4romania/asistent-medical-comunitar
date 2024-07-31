<?php

declare(strict_types=1);

namespace App\Reports\Standard\General;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

class G05 extends GeneralReport
{
    public function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VFV_03');
            });
    }
}
