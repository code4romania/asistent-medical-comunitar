<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Forms\Components\Card;
use App\Forms\Components\Value;
use App\Models\Beneficiary;
use Filament\Resources\Form;
use Filament\Resources\Pages\EditRecord;

class EditBeneficiary extends EditRecord implements WithSidebar
{
    use Concerns\CommonFormSchema;
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
                    Card::make()
                        ->columns(2)
                        ->schema([
                            Value::make('amc')
                                ->content(fn (Beneficiary $record) => "#{$record->amc->id} – {$record->amc->full_name}"),

                            Value::make('id')
                                ->content(fn (Beneficiary $record) => $record->id),

                            Value::make('type')
                                ->content(fn (Beneficiary $record) => $record->type?->label()),

                            Value::make('status')
                                ->content(fn (Beneficiary $record) => $record->status?->label()),
                        ]),

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
