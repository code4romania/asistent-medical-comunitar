<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Enums\Employer\Funding;
use App\Enums\Employer\Type;
use App\Filament\Forms\Components\Card;
use App\Filament\Forms\Components\Location;
use App\Filament\Forms\Components\Repeater;
use App\Filament\Forms\Components\Subsection;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;

class EditEmployers extends EditRecord
{
    protected function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema(static::getSchema());
    }

    public static function getSchema(): array
    {
        return [
            Repeater::make('employers')
                ->relationship('employers')
                ->label(__('employer.label.plural'))
                ->createItemButtonLabel(__('employer.action.create'))
                ->minItems(1)
                ->schema([
                    Subsection::make()
                        ->icon('heroicon-o-office-building')
                        ->columns(2)
                        ->schema([
                            TextInput::make('name')
                                ->label(__('field.employer_name'))
                                ->placeholder(__('placeholder.employer_name'))
                                ->maxLength(200)
                                ->required(),

                            Select::make('type')
                                ->label(__('field.employer_type'))
                                ->placeholder(__('placeholder.choose'))
                                ->options(Type::options())
                                ->enum(Type::class)
                                ->required(),

                            Select::make('funding')
                                ->label(__('field.funding'))
                                ->placeholder(__('placeholder.choose'))
                                ->options(Funding::options())
                                ->enum(Funding::class),

                            Group::make()
                                ->extraAttributes(['class' => 'flex h-full justify-end items-center'])
                                ->schema([
                                    Checkbox::make('is_project_based')
                                        ->label(__('field.employer_project_based'))
                                        ->reactive()
                                        ->afterStateUpdated(function (callable $set) {
                                            $set('project', null);
                                        }),
                                ]),

                            Card::make()
                                ->columnSpanFull()
                                ->pointer('right')
                                ->hidden(fn (callable $get) => $get('is_project_based') === false)
                                ->schema([
                                    TextInput::make('project')
                                        ->label(__('field.employer_project'))
                                        ->placeholder(__('placeholder.employer_project'))
                                        ->reactive()
                                        ->maxLength(200)
                                        ->afterStateHydrated(function (callable $set, $state) {
                                            $set('is_project_based', $state !== null);
                                        }),
                                ]),

                            Location::make(),

                            TextInput::make('email')
                                ->label(__('field.employer_email'))
                                ->placeholder(__('placeholder.email'))
                                ->maxLength(200)
                                ->email(),

                            TextInput::make('phone')
                                ->label(__('field.employer_phone'))
                                ->placeholder(__('placeholder.phone'))
                                ->tel()
                                ->maxLength(15),

                            DatePicker::make('start_date')
                                ->label(__('field.start_date'))
                                ->placeholder(__('placeholder.date')),

                            Group::make()
                                ->schema([
                                    DatePicker::make('end_date')
                                        ->label(__('field.end_date'))
                                        ->placeholder(__('placeholder.date'))
                                        ->afterOrEqual('start_date')
                                        ->disabled(function (callable $get) {
                                            return $get('is_ongoing') === true;
                                        })
                                        ->afterStateHydrated(function (callable $set, $state) {
                                            $set('is_ongoing', $state === null);
                                        }),

                                    Group::make()
                                        ->extraAttributes(['class' => 'flex justify-end'])
                                        ->columnSpanFull()
                                        ->schema([
                                            Checkbox::make('is_ongoing')
                                                ->label(__('field.employer_ongoing'))
                                                ->reactive()
                                                ->afterStateUpdated(function (callable $set) {
                                                    $set('end_date', null);
                                                }),
                                        ]),
                                ]),

                            Checkbox::make('has_gp_agreement')
                                ->label(__('field.has_gp_agreement'))
                                ->reactive()
                                ->afterStateUpdated(function (callable $set) {
                                    $set('end_date', null);
                                }),

                            Card::make()
                                ->columnSpanFull()
                                ->hidden(fn (callable $get) => $get('has_gp_agreement') === false)
                                ->columns()
                                ->pointer()
                                ->schema([
                                    TextInput::make('gp_name')
                                        ->label(__('field.gp_name'))
                                        ->placeholder(__('placeholder.gp_name'))
                                        ->maxLength(200)
                                        ->columnSpanFull(),

                                    TextInput::make('gp_email')
                                        ->label(__('field.gp_email'))
                                        ->placeholder(__('placeholder.email'))
                                        ->maxLength(200)
                                        ->email(),

                                    TextInput::make('gp_phone')
                                        ->label(__('field.gp_phone'))
                                        ->placeholder(__('placeholder.phone'))
                                        ->tel()
                                        ->maxLength(15),
                                ]),
                        ]),
                ]),
        ];
    }
}
