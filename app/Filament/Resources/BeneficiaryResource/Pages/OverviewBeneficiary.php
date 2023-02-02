<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Concerns\BeneficiarySidebar;
use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource;
use App\Forms\Components\Badge;
use App\Forms\Components\Placeholder;
use App\Models\Beneficiary;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Section;
use Filament\Pages\Actions;
use Filament\Resources\Form;
use Filament\Resources\Pages\ViewRecord;

class OverviewBeneficiary extends ViewRecord implements WithSidebar
{
    use BeneficiarySidebar;

    protected static string $resource = BeneficiaryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return $this->getRecord()->full_name;
    }

    protected function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Card::make()
                    ->columnSpan(1)
                    ->schema([
                        Section::make(__('beneficiary.section.personal_data'))
                            ->columns(2)
                            ->schema([
                                Badge::make('status')
                                    ->content(fn (Beneficiary $record) => $record->status?->label())
                                    ->color(fn (Beneficiary $record) => $record->status?->color())
                                    ->columnSpanFull(),
                                Placeholder::make('id')
                                    ->label(__('field.beneficiary_id'))
                                    ->content(fn (Beneficiary $record) => $record->id),
                                Placeholder::make('integrated')
                                    ->label(__('field.integrated'))
                                    ->content('Placeholder content'),
                                Placeholder::make('household')
                                    ->label(__('field.household'))
                                    ->content('Placeholder content'),
                                Placeholder::make('family')
                                    ->label(__('field.family'))
                                    ->content('Placeholder content'),
                                Placeholder::make('age')
                                    ->label(__('field.age'))
                                    ->content(fn (Beneficiary $record) => $record->age),
                                Placeholder::make('gender')
                                    ->label(__('field.gender'))
                                    ->content(fn (Beneficiary $record) => $record->gender?->label()),
                                Placeholder::make('address')
                                    ->label(__('field.address'))
                                    ->content(fn (Beneficiary $record) => $record->full_address)
                                    ->columnSpanFull(),
                                Placeholder::make('phone')
                                    ->label(__('field.phone'))
                                    ->content(fn (Beneficiary $record) => $record->phone)
                                    ->columnSpanFull(),
                            ]),
                    ]),

                Card::make()
                    ->columnSpan(2)
                    ->schema([
                        Section::make(__('beneficiary.section.active_interventions'))
                            ->schema([

                            ]),
                    ]),
            ]);
    }
}
