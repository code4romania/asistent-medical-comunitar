<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Pages;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Get;
use App\Enums\Beneficiary\Type;
use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Beneficiaries\Schemas\OcasionalBeneficiaryForm;
use App\Filament\Resources\Beneficiaries\Schemas\RegularBeneficiaryForm;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\CreateRecord;

class CreateBeneficiary extends CreateRecord
{
    protected static string $resource = BeneficiaryResource::class;

    protected static bool $canCreateAnother = false;

    public function getTitle(): string
    {
        return __('beneficiary.header.create');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
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
