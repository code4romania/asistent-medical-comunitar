<?php

declare(strict_types=1);

namespace App\Reports\Standard\General;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

class G02 extends Report
{
    /**
     * Sum beneficiari with Femeie care utilizează metode contraceptive (VGR_14).
     */
    public function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VGR_14');
            });
    }
}
