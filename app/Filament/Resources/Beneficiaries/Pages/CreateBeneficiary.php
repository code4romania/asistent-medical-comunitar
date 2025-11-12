<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Pages;

use App\Enums\Beneficiary\Type;
use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Beneficiaries\Concerns\HasBreadcrumbs;
use App\Filament\Resources\Beneficiaries\Schemas\OcasionalBeneficiaryForm;
use App\Filament\Resources\Beneficiaries\Schemas\RegularBeneficiaryForm;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Illuminate\Support\Facades\Auth;

class CreateBeneficiary extends CreateRecord
{
    use HasBreadcrumbs;

    protected static string $resource = BeneficiaryResource::class;

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
                    ->components([
                        Select::make('type')
                            ->label(__('field.beneficiary_type'))
                            ->options(Type::class)
                            ->default(Type::REGULAR->value)
                            ->selectablePlaceholder(false)
                            ->maxWidth(Width::ExtraSmall)
                            ->required()
                            ->live(),

                        Group::make()
                            ->visible(fn (Get $get) => Type::REGULAR->is($get('type')))
                            ->components(fn (Schema $schema) => RegularBeneficiaryForm::configure($schema)),

                        Group::make()
                            ->visible(fn (Get $get) => Type::OCASIONAL->is($get('type')))
                            ->components(fn (Schema $schema) => OcasionalBeneficiaryForm::configure($schema)),

                    ]),
            ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['nurse_id'] = Auth::id();

        return $data;
    }
}
