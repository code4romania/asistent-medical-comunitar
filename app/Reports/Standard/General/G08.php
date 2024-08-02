<?php

declare(strict_types=1);

namespace App\Reports\Standard\General;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

class G08 extends GeneralReport
{
    /**
     * Sum beneficiari with Tuberculoză (VSG_TB); Adult 18-65 ani (VCV_05).
     */
    public function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', ['VSG_TB', 'VCV_05']);
            });
    }
}
