<?php

declare(strict_types=1);

namespace App\Reports\Standard\General;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

class G16 extends GeneralReport
{
    /**
     * Sum beneficiari with Tuberculoză (VSG_TB); Vârstnic peste 65 ani (VCV_06).
     */
    public function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', ['VSG_TB', 'VCV_06']);
            });
    }
}
