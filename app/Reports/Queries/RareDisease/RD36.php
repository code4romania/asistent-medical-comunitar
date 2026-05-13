<?php

declare(strict_types=1);

namespace App\Reports\Queries\RareDisease;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

/**
 * Sum beneficiari with G-sindrom Marfan (VBR_SM).
 */
class RD36 extends RareDiseaseQuery
{
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VBR_SM');
            });
    }
}
