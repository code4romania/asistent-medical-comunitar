<?php

declare(strict_types=1);

namespace App\Tables\Columns;

use Filament\Actions\ViewAction;
use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Models\Beneficiary;
use Filament\Tables\Columns\ViewColumn;

class HouseholdFamiliesColumn extends ViewColumn
{
    protected string $view = 'tables.columns.household-families-column';

    public function getActions(Beneficiary $beneficiary): array
    {
        $url = BeneficiaryResource::getUrl('view', [
            'record' => $beneficiary,
        ]);

        return [
            ViewAction::make()
                ->label(__('beneficiary.action.view_details'))
                ->record($beneficiary)
                ->color('primary')
                ->size('sm')
                ->icon(null)
                ->url($url)
                ->extraAttributes([
                    'class' => 'whitespace-nowrap',
                ]),
        ];
    }
}
