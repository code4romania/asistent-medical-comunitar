<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Forms\Components\Card;
use App\Forms\Components\Placeholder;
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
                            Placeholder::make('amc')
                                ->content(fn (Beneficiary $record) => "#{$record->amc->id} – {$record->amc->full_name}"),

                            Placeholder::make('id')
                                ->content(fn (Beneficiary $record) => $record->id),

                            Placeholder::make('type')
                                ->content(fn (Beneficiary $record) => $record->type?->label()),

                            Placeholder::make('status')
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
