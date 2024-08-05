<?php

declare(strict_types=1);

namespace App\Reports\Standard\General;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

class G23 extends Report
{
    /**
     * Sum beneficiari with Lăuză adultă (VGR_08) + Minoră lăuză (VGR_02).
     */
    public function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VGR_08')
                    ->orWhereJsonContains('properties', 'VGR_02');
            });
    }
}
