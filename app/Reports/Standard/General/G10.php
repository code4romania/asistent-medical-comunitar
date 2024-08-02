<?php

declare(strict_types=1);

namespace App\Reports\Standard\General;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

class G10 extends GeneralReport
{
    /*
     * Sum beneficiari with Dizabilitate cu certificat (VDH_01) + Dizabilitate fără certificat (VDH_02); Adult 18-65 ani (VCV_05).
     */
    public function query(): Builder
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
