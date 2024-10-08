<?php

declare(strict_types=1);

namespace App\Reports\Queries\General;

use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class G10 extends ReportQuery
{
    /*
     * Sum beneficiari with Dizabilitate cu certificat (VDH_01) + Dizabilitate fără certificat (VDH_02); Adult 18-65 ani (VCV_05).
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VCV_05')
                    ->where(function (Builder $query) {
                        $query->whereJsonContains('properties', 'VDH_01')
                            ->orWhereJsonContains('properties', 'VDH_02');
                    });
            });
    }
}
