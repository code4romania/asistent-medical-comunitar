<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Contracts\Forms\FixedActionBar;
use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Forms\Components\BeneficiaryProgram;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditBeneficiary extends EditRecord implements WithSidebar, FixedActionBar
{
    use Concerns\CommonEditFormSchema;
    use Concerns\HasActions;
    use Concerns\HasRecordBreadcrumb;
    use Concerns\HasSidebar;

    protected static string $resource = BeneficiaryResource::class;

    public function mount(int | string $record): void
    {
        parent::mount($record);

        $this->resolveBeneficiary($record);
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
            return $form
                ->columns(1)
                ->schema([
                    BeneficiaryProgram::make(),

                    Section::make()
                        ->header(__('beneficiary.section.personal_data'))
                        ->schema(static::getRegularBeneficiaryFormSchema()),
                ]);
        }

        return $form
            ->columns(1)
            ->schema([
                Section::make()
                    ->header(__('beneficiary.section.personal_data'))
                    ->schema(static::getOcasionalBeneficiaryFormSchema()),
            ]);
    }

    public function getRelationManagers(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getRedirectUrl(): string
    {
        if ($this->getRecord()->isRegular()) {
            return static::getResource()::getUrl('personal_data', $this->getRecord());
        }

        return static::getResource()::getUrl('view', $this->getRecord());
    }
}
