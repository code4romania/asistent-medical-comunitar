<?php

declare(strict_types=1);

namespace App\Filament\Resources\HouseholdResource\Pages;

use App\Concerns\HasConditionalTableEmptyState;
use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\HouseholdResource;
use Filament\Pages;
use Filament\Resources\Pages\ManageRecords;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class ManageHouseholds extends ManageRecords implements WithTabs
{
    use HasConditionalTableEmptyState;
    use BeneficiaryResource\Concerns\HasRecordBreadcrumb;
    use BeneficiaryResource\Concerns\HasTabs;

    protected static string $resource = HouseholdResource::class;

    protected function getActions(): array
    {
        return [
            Pages\Actions\CreateAction::make()
                ->disableCreateAnother(),
        ];
    }

    protected function getTableEmptyStateIcon(): ?string
    {
        if ($this->hasAlteredTableQuery()) {
            return null;
        }

        return 'icon-empty-state';
    }

    protected function getTableEmptyStateHeading(): ?string
    {
        if ($this->hasAlteredTableQuery()) {
            return null;
        }

        return __('household.empty.title');
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        if ($this->hasAlteredTableQuery()) {
            return null;
        }

        return __('household.empty.description');
    }

    protected function getTableEmptyStateActions(): array
    {
        return [
            Tables\Actions\CreateAction::make()
                ->label(__('household.empty.create'))
                ->modalHeading(__('household.empty.create'))
                ->button()
                ->color('secondary')
                ->disableCreateAnother()
                ->form(HouseholdResource::getFormSchema())
                ->hidden(fn () => $this->hasAlteredTableQuery()),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->with([
                'families.beneficiaries.catagraphy' => function ($query) {
                    $query->select([
                        'cat_age',
                        'cat_as',
                        'cat_cr',
                        'cat_diz',
                        'cat_diz_tip',
                        'cat_diz_gr',
                        'cat_edu',
                        'cat_fam',
                        'cat_id',
                        'cat_inc',
                        'cat_liv',
                        'cat_mf',
                        'cat_ns',
                        'cat_pov',
                        'cat_preg',
                        'cat_rep',
                        'cat_ss',
                        'cat_ssa',
                        'cat_vif',
                        'beneficiary_id',
                    ]);
                },
            ])
            ->orderBy('created_at', 'desc');
    }
}
