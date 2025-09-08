<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Pages;

use App\Enums\User\Role;
use App\Filament\Resources\Users\UserResource;
use App\Filament\Resources\Users\Pages\Nurse\EditArea;
use App\Forms\Components\Location;
use App\Forms\Components\Subsection;
use App\Forms\Components\Value;
use App\Models\City;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected static bool $canCreateAnother = false;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components(static::getFormSchema());
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['role'] ??= Role::NURSE;

        if (
            auth()->user()->isCoordinator() &&
            Role::isValue($data['role'], Role::NURSE)
        ) {
            $data['activity_county_id'] = auth()->user()->county_id;
        }

        return $data;
    }

    public static function getFormSchema(): array
    {
        return [
            Section::make()
                ->schema([
                    Subsection::make()
                        ->icon('heroicon-o-user')
                        ->columns(2)
                        ->schema([
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
                                ->options(Role::options())
                                ->enum(Role::class)
                                ->live()
                                ->required()
                                ->visible(fn () => auth()->user()->isAdmin()),

                            Location::make()
                                ->label(__('field.county'))
                                ->withoutCity()
                                ->required()
                                ->visible(fn (Get $get) => Role::isValue($get('role'), Role::COORDINATOR))
                                ->columnSpan(1),
                        ]),
                ]),

            Section::make()
                ->visible(fn (Get $get) => Role::isValue($get('role'), Role::NURSE) && auth()->user()->isAdmin())
                ->schema(EditArea::getFormSchema()),

            Section::make()
                ->visible(fn () => auth()->user()->isCoordinator())
                ->schema([
                    Subsection::make()
                        ->icon('heroicon-o-map-pin')
                        ->columns()
                        ->schema([
                            Value::make('activity_county_id')
                                ->label(__('field.county'))
                                ->content(fn () => auth()->user()->county->name),

                            Select::make('activity_cities')
                                ->label(__('field.cities'))
                                ->placeholder(__('placeholder.cities'))
                                ->relationship('activityCities', 'name')
                                ->multiple()
                                ->allowHtml()
                                ->searchable()
                                ->required()
                                ->getSearchResultsUsing(
                                    fn (string $search, Get $get) => City::query()
                                        ->where('county_id', auth()->user()->county_id)
                                        ->search($search)
                                        ->limit(100)
                                        ->get()
                                        ->mapWithKeys(fn (City $city) => [
                                            $city->getKey() => Location::getRenderedOptionLabel($city),
                                        ])
                                )
                                ->getOptionLabelFromRecordUsing(
                                    fn (City $record) => Location::getRenderedOptionLabel($record)
                                ),
                        ]),
                ]),
        ];
    }
}
