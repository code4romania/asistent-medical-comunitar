<?php

declare(strict_types=1);

namespace App\Reports\Standard\Child;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

class C23 extends Report
{
    /**
     * Sum beneficiari with Copil cu un singur părinte acasă (VFC_01).
     */
    public function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VFC_01');
            });
    }
}
