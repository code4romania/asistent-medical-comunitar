<?php

declare(strict_types=1);

namespace App\Reports\Standard\General;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

class G18 extends Report
{
    /**
     * Sum beneficiari with Tulburări mintale şi de comportament (VSG_TMC); Vârstnic peste 65 ani (VCV_06).
     */
    public function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', ['VSG_TMC', 'VCV_06']);
            });
    }
}
