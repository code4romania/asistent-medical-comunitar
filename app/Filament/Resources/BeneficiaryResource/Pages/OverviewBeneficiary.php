<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Contracts\Pages\WithSidebar;
use App\Filament\Actions\ConvertOcasionalBeneficiaryAction;
use App\Filament\Forms\Components\Card;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Filament\Resources\BeneficiaryResource\Widgets\ActiveInterventionsWidget;
use App\Filament\Resources\BeneficiaryResource\Widgets\PersonalDataWidget;
use Filament\Pages\Actions;
use Filament\Resources\Form;
use Filament\Resources\Pages\ViewRecord;

class OverviewBeneficiary extends ViewRecord implements WithSidebar
{
    use Concerns\CommonViewFormSchema;
    use Concerns\HasActions;
    use Concerns\HasRecordBreadcrumb;
    use Concerns\HasSidebar;

    protected static string $resource = BeneficiaryResource::class;

    public function mount($record): void
    {
        parent::mount($record);

        $this->resolveBeneficiary($record);
    }

    protected function getActions(): array
    {
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

    protected function form(Form $form): Form
    {
        if ($this->getRecord()->isRegular()) {
            return $form;
        }

        return $form
            ->schema([
                Card::make()
                    ->header(__('beneficiary.section.personal_data'))
                    ->schema(static::getOcasionalBeneficiaryFormSchema()),
            ]);
    }

    protected function getHeaderWidgetsColumns(): int
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
