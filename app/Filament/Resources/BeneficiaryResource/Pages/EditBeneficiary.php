<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Contracts\Forms\FixedActionBar;
use App\Contracts\Pages\WithSidebar;
use App\Filament\Forms\Components\BeneficiaryProgram;
use App\Filament\Forms\Components\Card;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use Filament\Resources\Form;
use Filament\Resources\Pages\EditRecord;

class EditBeneficiary extends EditRecord implements WithSidebar, FixedActionBar
{
    use Concerns\CommonEditFormSchema;
    use Concerns\HasActions;
    use Concerns\HasRecordBreadcrumb;
    use Concerns\HasSidebar;

    protected static string $resource = BeneficiaryResource::class;

    public function mount($record): void
    {
        parent::mount($record);

        $this->resolveBeneficiary($record);
    }

    protected function form(Form $form): Form
    {
        if ($this->getRecord()->isRegular()) {
            return $form
                ->columns(1)
                ->schema([
                    BeneficiaryProgram::make(),

                    Card::make()
                        ->header(__('beneficiary.section.personal_data'))
                        ->schema(static::getRegularBeneficiaryFormSchema()),
                ]);
        }

        return $form
            ->columns(1)
            ->schema([
                Card::make()
                    ->header(__('beneficiary.section.personal_data'))
                    ->schema(static::getOcasionalBeneficiaryFormSchema()),
            ]);
    }

    protected function getRelationManagers(): array
    {
        return [];
    }

    protected function getActions(): array
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
