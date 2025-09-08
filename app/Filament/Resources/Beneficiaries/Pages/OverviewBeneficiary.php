<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Pages;

use App\Filament\Resources\Beneficiaries\Concerns\HasActions;
use App\Filament\Resources\Beneficiaries\Concerns\HasRecordBreadcrumb;
use Filament\Actions\EditAction;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use App\Filament\Actions\ConvertOcasionalBeneficiaryAction;
use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Filament\Resources\Beneficiaries\Widgets\ActiveInterventionsWidget;
use App\Filament\Resources\Beneficiaries\Widgets\PersonalDataWidget;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class OverviewBeneficiary extends ViewRecord
{
    use HasActions {
        getActions as getActionsFromTrait;
    }

    use HasRecordBreadcrumb;

    protected static string $resource = BeneficiaryResource::class;

    public function mount(int | string $record): void
    {
        parent::mount($record);

        $this->resolveBeneficiary($record);
    }

    protected function getHeaderActions(): array
    {
        if ($this->getRecord()->isRegular()) {
            return $this->getActionsFromTrait();
        }

        return [
            ConvertOcasionalBeneficiaryAction::make()
                ->record($this->getRecord()),

            EditAction::make()
                ->icon('heroicon-s-pencil'),
        ];
    }

    public function getTitle(): string
    {
        return $this->getRecord()->full_name ?? __('field.has_unknown_identity');
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }

    public function form(Schema $schema): Schema
    {
        if ($this->getRecord()->isRegular()) {
            return $schema;
        }

        return $schema
            ->components([
                Section::make()
                    ->heading(__('beneficiary.section.personal_data'))
                    ->schema(static::getOcasionalBeneficiaryFormSchema()),
            ]);
    }

    public function getHeaderWidgetsColumns(): int|array
    {
        return 3;
    }

    protected function getHeaderWidgets(): array
    {
        if ($this->getRecord()->isOcasional()) {
            return [];
        }

        return [
            PersonalDataWidget::class,
            ActiveInterventionsWidget::class,
        ];
    }
}
