<?php

declare(strict_types=1);

namespace App\Reports\Queries\RareDisease;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

/**
 * Sum beneficiari with AC-sindrom DiGeorge-velocardiofacial (VBR_DG).
 */
class RD12 extends RareDiseaseQuery
{
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VBR_DG');
            });
    }
}
