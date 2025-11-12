<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\User\Role;
use App\Filament\Forms\Components\Location;
use App\Filament\Resources\Profiles\Schemas\AreaForm;
use App\Filament\Schemas\Components\Subsection;
use App\Models\City;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make()
                    ->components([
                        Subsection::make()
                            ->icon(Heroicon::OutlinedUser)
                            ->columns(2)
                            ->components([
                                TextInput::make('first_name')
                                    ->label(__('field.first_name'))
                                    ->placeholder(__('placeholder.first_name'))
                                    ->maxLength(50)
                                    ->required(),

                                TextInput::make('last_name')
                                    ->label(__('field.last_name'))
                                    ->placeholder(__('placeholder.last_name'))
                                    ->maxLength(50)
                                    ->required(),

                                TextInput::make('email')
                                    ->label(__('field.email'))
                                    ->placeholder(__('placeholder.email'))
                                    ->unique(ignoreRecord: true)
                                    ->email()
                                    ->maxLength(200)
                                    ->required(),

                                TextInput::make('phone')
                                    ->label(__('field.phone'))
                                    ->placeholder(__('placeholder.phone'))
                                    ->tel()
                                    ->maxLength(15),

                                Select::make('role')
                                    ->label(__('field.role'))
                                    ->options(Role::class)
                                    ->live()
                                    ->required()
                                    ->visible(fn () => auth()->user()->isAdmin())
                                    ->default(Role::NURSE),

                                Location::make()
                                    ->contained(false)
                                    ->city(false)
                                    ->required()
                                    ->visible(fn (Get $get) => Role::COORDINATOR->is($get('role')))
                                    ->columnSpan(1),
                            ]),
                    ]),

                Section::make()
                    ->visible(fn (Get $get) => auth()->user()->isAdmin() && Role::NURSE->is($get('role')))
                    ->components(fn (Schema $schema) => AreaForm::configure($schema, canEditCounty: true)),

                Section::make()
                    ->visible(fn () => auth()->user()->isCoordinator())
                    ->components([
                        Subsection::make()
                            ->icon(Heroicon::OutlinedMapPin)
                            ->columns()
                            ->components([
                                TextEntry::make('activity_county')
                                    ->label(__('field.county'))
                                    ->default(fn () => auth()->user()->county->name),

                                Select::make('activity_cities')
                                    ->label(__('field.cities'))
                                    ->placeholder(__('placeholder.cities'))
                                    ->relationship('activityCities', 'name')
                                    ->multiple()
                                    ->allowHtml()
                                    ->searchable()
                                    ->required()
                                    ->getSearchResultsUsing(
                                        fn (string $search) => City::query()
                                            ->where('county_id', auth()->user()->county_id)
                                            ->search($search)
                                            ->limit(100)
                                            ->get()
                                            ->mapWithKeys(fn (City $city) => [
                                                $city->getKey() => $city->formatted_name,
                                            ])
                                    )
                                    ->getOptionLabelFromRecordUsing(fn (City $record) => $record->formatted_name),
                            ]),
                    ]),
            ]);
    }
}
