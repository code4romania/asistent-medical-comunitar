<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Concerns\Beneficiary\CommonFormSchema;
use App\Enums\Beneficiary\Type;
use App\Filament\Resources\BeneficiaryResource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Pages\CreateRecord;

class CreateBeneficiary extends CreateRecord
{
    use CommonFormSchema;

    protected static string $resource = BeneficiaryResource::class;

    protected static bool $canCreateAnother = false;

    protected function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Card::make()
                    ->schema([
                        Grid::make(['md' => 3])
                            ->schema([
                                Select::make('type')
                                    ->label(__('field.beneficiary_type'))
                                    ->options(Type::options())
                                    ->default(Type::REGULAR->value)
                                    ->disablePlaceholderSelection()
                                    ->reactive()
                                    ->required(),
                            ]),

                        Group::make()
                            ->visible(fn ($state) => $state['type'] === Type::REGULAR->value)
                            ->schema(static::getRegularBeneficiaryFormSchema()),

                        Group::make()
                            ->visible(fn ($state) => $state['type'] === Type::OCASIONAL->value)
                            ->schema(static::getOcasionalBeneficiaryFormSchema()),
                    ]),
            ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['amc_id'] = auth()->id();

        return $data;
    }
}
