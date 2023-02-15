<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Concerns\Beneficiary\CommonFormSchema;
use App\Concerns\Beneficiary\SidebarLayout;
use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource;
use App\Forms\Components\Card;
use App\Forms\Components\Placeholder;
use App\Models\Beneficiary;
use Filament\Pages\Actions;
use Filament\Resources\Form;
use Filament\Resources\Pages\EditRecord;

class EditBeneficiary extends EditRecord implements WithSidebar
{
    use CommonFormSchema;
    use SidebarLayout;

    protected static string $resource = BeneficiaryResource::class;

    protected function getActions(): array
    {
        return [
            // Actions\ViewAction::make(),
            // Actions\DeleteAction::make(),
        ];
    }

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
                        ->heading(__('beneficiary.section.personal_data'))
                        ->schema(static::getRegularBeneficiaryFormSchema()),
                ]);
        }

        return $form
            ->columns(1)
            ->schema([
                Card::make()
                    ->heading(__('beneficiary.section.personal_data'))
                    ->schema(static::getOcasionalBeneficiaryFormSchema()),
            ]);
    }
}
