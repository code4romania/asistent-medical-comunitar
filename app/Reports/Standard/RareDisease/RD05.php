<?php

declare(strict_types=1);

namespace App\Reports\Standard\RareDisease;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

class RD05 extends Report
{
    /**
     * Sum beneficiari with AC-sindrom Lejeune (cri du chat) (VBR_LJ).
     */
    public function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VBR_LJ');
            });
    }
}
