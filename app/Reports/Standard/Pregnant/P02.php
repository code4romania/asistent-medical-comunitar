<?php

declare(strict_types=1);

namespace App\Reports\Standard\Pregnant;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

class P02 extends Report
{
    /**
     * Sum beneficiari with Gravidă adultă (VGR_04); Boală cronică (VSG_01) OR Episod acut recent (VSG_02).
     */
    public function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VGR_04')
                    ->where(function (Builder $query) {
                        $query->whereJsonContains('properties', 'VSG_01')
                            ->orWhereJsonContains('properties', 'VSG_02');
                    });
            });
    }
}