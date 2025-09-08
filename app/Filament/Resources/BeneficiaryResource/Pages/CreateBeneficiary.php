<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Enums\Beneficiary\Type;
use App\Filament\Resources\AppointmentResource\Schemas\OcasionalBeneficiaryForm;
use App\Filament\Resources\AppointmentResource\Schemas\RegularBeneficiaryForm;
use App\Filament\Resources\BeneficiaryResource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Pages\CreateRecord;

class CreateBeneficiary extends CreateRecord
{
    protected static string $resource = BeneficiaryResource::class;

    protected static bool $canCreateAnother = false;

    public function getTitle(): string
    {
        return __('beneficiary.header.create');
    }

    public function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Section::make()
                    ->schema([
                        Grid::make(['md' => 3])
                            ->schema([
                                Select::make('type')
                                    ->label(__('field.beneficiary_type'))
                                    ->options(Type::options())
                                    ->default(Type::REGULAR->value)
                                    ->disablePlaceholderSelection()
                                    ->live()
                                    ->required(),
                            ]),

                        Group::make()
                            ->visible(fn (Get $get) => Type::REGULAR->is($get('type')))
                            ->schema(RegularBeneficiaryForm::getSchema()),

                        Group::make()
                            ->visible(fn (Get $get) => Type::OCASIONAL->is($get('type')))
                            ->schema(OcasionalBeneficiaryForm::getSchema()),
                    ]),
            ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['nurse_id'] = auth()->id();

        return $data;
    }

    public function getRelationManagers(): array
    {
        return [];
    }
}
