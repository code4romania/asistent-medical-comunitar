<?php

declare(strict_types=1);

namespace App\Reports\Standard\Child;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

class C24 extends Report
{
    /**
     * Sum beneficiari with Copil 0-1 ani (VCV_01) OR Copil 1-5 ani (VCV_02) OR Copil 5-14 ani (VCV_03); Dizabilitate cu certificat (VDH_01) OR Dizabilitate fără certificat (VDH_02).
     */
    public function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query
                    ->where(function (Builder $query) {
                        $query->whereJsonContains('properties', 'VDH_01')
                            ->orWhereJsonContains('properties', 'VDH_02');
                    })
                    ->where(function (Builder $query) {
                        $query->whereJsonContains('properties', 'VCV_01')
                            ->orWhereJsonContains('properties', 'VCV_02')
                            ->orWhereJsonContains('properties', 'VCV_03');
                    });
            });
    }
}
