<?php

declare(strict_types=1);

namespace App\Reports\Standard\General;

use App\Filament\Resources\BeneficiaryResource;
use App\Reports\Standard\StandardReport;

abstract class GeneralReport extends StandardReport
{
    public function dateColumn(): string
    {
        return 'activity_log.created_at';
    }

    public function columns(): array
    {
        return [
            'id' => __('field.id'),
            'first_name' => __('field.first_name'),
            'last_name' => __('field.last_name'),
            'cnp' => __('field.cnp'),
            'gender' => __('field.gender'),
            'date_of_birth' => __('field.age'),
            'county_id' => __('field.county'),
            'city_id' => __('field.city'),
            'status' => __('field.status'),
        ];
    }

    public function getRecordActions(): array
    {
        return [
            BeneficiaryResource::getUrl('view', ['record' => 'RECORD']) => __('beneficiary.action.view_details'),
        ];
    }
}
