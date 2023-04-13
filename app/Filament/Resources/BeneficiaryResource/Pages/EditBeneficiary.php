<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Contracts\Forms\FixedActionBar;
use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Forms\Components\BeneficiaryProgram;
use App\Forms\Components\Card;
use Filament\Resources\Form;
use Filament\Resources\Pages\EditRecord;

class EditBeneficiary extends EditRecord implements WithSidebar, FixedActionBar
{
    use Concerns\CommonEditFormSchema;
    use Concerns\HasActions;
    use Concerns\HasRecordBreadcrumb;
    use Concerns\HasSidebar;

    protected static string $resource = BeneficiaryResource::class;

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
}
