<?php

declare(strict_types=1);

namespace App\Reports\Standard\RareDisease;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

class RD39 extends Report
{
    /**
     * Sum beneficiari with G-sindrom Noonan-rasopatie (VBR_SNR).
     */
    public function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VBR_SNR');
            });
    }
}
