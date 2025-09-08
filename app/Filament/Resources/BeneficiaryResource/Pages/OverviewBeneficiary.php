<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Filament\Actions\ConvertOcasionalBeneficiaryAction;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Filament\Resources\BeneficiaryResource\Widgets\ActiveInterventionsWidget;
use App\Filament\Resources\BeneficiaryResource\Widgets\PersonalDataWidget;
use Filament\Actions;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;

class OverviewBeneficiary extends ViewRecord
{
    use Concerns\HasActions {
        getActions as getActionsFromTrait;
    }

    use Concerns\HasRecordBreadcrumb;

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

            Actions\EditAction::make()
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

    public function form(Form $form): Form
    {
        if ($this->getRecord()->isRegular()) {
            return $form;
        }

        return $form
            ->schema([
                Section::make()
                    ->heading(__('beneficiary.section.personal_data'))
                    ->schema(static::getOcasionalBeneficiaryFormSchema()),
            ]);
    }

    public function getHeaderWidgetsColumns(): int
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
