<?php

declare(strict_types=1);

namespace App\Reports\Standard\General;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

class G17 extends Report
{
    /*
     * Sum beneficiari with Dizabilitate cu certificat (VDH_01) + Dizabilitate fără certificat (VDH_02); Vârstnic peste 65 ani (VCV_06)
     */
    public function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VCV_06')
                    ->where(function (Builder $query) {
                        $query->whereJsonContains('properties', 'VDH_01')
                            ->orWhereJsonContains('properties', 'VDH_02');
                    });
            });
    }
}
