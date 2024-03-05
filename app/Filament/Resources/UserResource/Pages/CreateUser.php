<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages;

use App\Enums\User\Role;
use App\Filament\Forms\Components\Card;
use App\Filament\Forms\Components\Location;
use App\Filament\Forms\Components\Subsection;
use App\Filament\Resources\UserResource;
use Closure;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected static bool $canCreateAnother = false;

    protected function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Card::make()
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
                                    ->unique()
                                    ->email()
                                    ->maxLength(200)
                                    ->required(),

                                TextInput::make('phone')
                                    ->label(__('field.phone'))
                                    ->placeholder(__('placeholder.phone'))
                                    ->tel()
                                    ->required()
                                    ->maxLength(15),

                                Select::make('role')
                                    ->label(__('field.role'))
                                    ->options(Role::options())
                                    ->enum(Role::class)
                                    ->reactive()
                                    ->required(),

                                Location::make()
                                    ->label(__('field.county'))
                                    ->withoutCity()
                                    ->required()
                                    ->visible(fn (Closure $get) => Role::isValue($get('role'), Role::COORDINATOR))
                                    ->columnSpan(1),

                            ]),
                    ]),

                Card::make()
                    ->visible(fn (Closure $get) => Role::isValue($get('role'), Role::NURSE))
                    ->schema(Nurse\EditArea::getSchema()),
            ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['role'] ??= Role::NURSE;

        return $data;
    }
}
