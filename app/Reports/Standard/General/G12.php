<?php

declare(strict_types=1);

namespace App\Reports\Standard\General;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

class G12 extends Report
{
    /*
     * Sum beneficiari with at least one vulnerability; Adult 18-65 ani (VCV_05)
     */
    public function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VCV_05')
                    ->whereJsonLength('properties', '>', 1);
            });
    }
}
