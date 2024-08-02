<?php

declare(strict_types=1);

namespace App\Reports\Standard\General;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

class G24 extends GeneralReport
{
    /**
     * Sum beneficiari fără vulenrabilități; Adult 18-65 ani (VCV_05).
     */
    public function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VCV_05')
                    // TODO: don't count properties ending in 97, 98, 99
                    ->whereJsonLength('properties', 1);
            });
    }
}
