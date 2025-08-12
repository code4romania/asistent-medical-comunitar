<?php

declare(strict_types=1);

namespace App\Filament\Resources\AppointmentResource\Schemas;

use App\Forms\Components\Subsection;
use Carbon\CarbonImmutable;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Builder;

class AppointmentForm
{
    public static function getSchema(): array
    {
        return [
            Section::make()
                ->schema([
                    Subsection::make()
                        ->heading(__('appointment.section.mandatory'))
                        ->icon('heroicon-o-document-text')
                        ->columns(3)
                        ->schema([
                            Select::make('beneficiary_id')
                                ->label(__('field.beneficiary'))
                                ->relationship('beneficiary', 'full_name', fn (Builder $query) => $query->onlyRegular())
                                ->searchable()
                                ->required()
                                ->preload(),

                            Grid::make(6)
                                ->columnSpanFull()
                                ->schema([
                                    DatePicker::make('date')
                                        ->label(__('field.date'))
                                        ->required()
                                        ->columnSpan(2),

                                    TextInput::make('start_time')
                                        ->label(__('field.start_time'))
                                        ->type('time')
                                        ->rule('date_format:H:i')
                                        ->reactive()
                                        ->required()
                                        ->afterStateUpdated(function ($old, $state, Get $get, Set $set) {
                                            if (blank($state)) {
                                                return;
                                            }

                                            /** @var CarbonImmutable */
                                            $oldStartTime = rescue(
                                                fn () => CarbonImmutable::createFromFormat('H:i', $old),
                                                report: false
                                            );

                                            /** @var CarbonImmutable */
                                            $endTime = rescue(
                                                fn () => CarbonImmutable::createFromFormat('H:i', $get('end_time')),
                                                report: false
                                            );

                                            $offset = $oldStartTime instanceof CarbonImmutable
                                                ? (int) abs($oldStartTime->diffInMinutes($endTime))
                                                : 60;

                                            $set(
                                                'end_time',
                                                CarbonImmutable::createFromFormat('H:i', $state)
                                                    ->addUnitNoOverflow('minute', $offset, 'day')
                                                    ->format('H:i')
                                            );
                                        }),

                                    TextInput::make('end_time')
                                        ->label(__('field.end_time'))
                                        ->type('time')
                                        ->after('start_time')
                                        ->required()
                                        ->disabled(fn (Get $get) => blank($get('start_time'))),
                                ]),
                        ]),

                    Subsection::make()
                        ->heading(__('appointment.section.additional'))
                        ->icon('heroicon-o-information-circle')
                        ->columns(3)
                        ->schema([
                            TextInput::make('type')
                                ->label(__('field.type'))
                                ->columnSpan(2)
                                ->nullable()
                                ->maxLength(100),

                            TextInput::make('location')
                                ->label(__('field.location'))
                                ->columnSpan(2)
                                ->nullable()
                                ->maxLength(100),

                            TextInput::make('attendant')
                                ->label(__('field.attendant'))
                                ->columnSpan(2)
                                ->nullable()
                                ->maxLength(100),
                        ]),

                    Subsection::make()
                        ->heading(__('appointment.section.notes'))
                        ->icon('heroicon-o-chat-bubble-bottom-center-text')
                        ->schema([
                            RichEditor::make('notes')
                                ->hiddenLabel()
                                ->toolbarButtons(['bold', 'italic', 'strike', 'bulletList', 'orderedList', 'redo', 'undo'])
                                ->nullable()
                                ->maxLength(65535),
                        ]),
                ]),
        ];
    }
}
