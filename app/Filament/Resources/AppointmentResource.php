<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers\ServicesRelationManager;
use App\Filament\Tables\Columns\TextColumn;
use App\Forms\Components\Card;
use App\Forms\Components\Subsection;
use App\Models\Appointment;
use Carbon\CarbonImmutable;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return __('appointment.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('appointment.label.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Card::make()
                    ->schema(static::getAppointmentFormSchema()),
            ]);
    }

    public static function getAppointmentFormSchema(): array
    {
        return [
            Subsection::make()
                ->title(__('appointment.section.mandatory'))
                ->icon('heroicon-o-document-text')
                ->columns(3)
                ->schema([
                    Select::make('beneficiary_id')
                        ->label(__('field.beneficiary'))
                        ->relationship('beneficiary', 'full_name', fn (Builder $query) => $query->onlyRegular())
                        ->searchable()
                        ->preload(),

                    Grid::make(6)
                        ->columnSpanFull()
                        ->schema([
                            DatePicker::make('date')
                                ->label(__('field.date'))
                                ->columnSpan(2),

                            TextInput::make('start_time')
                                ->label(__('field.start_time'))
                                ->type('time')
                                ->rule('date_format:H:i')
                                ->reactive()
                                ->afterStateUpdated(function ($old, $state, callable $get, callable $set) {
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

                                    $offset = $endTime instanceof CarbonImmutable
                                        ? $endTime->diffInMinutes($oldStartTime)
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
                                ->disabled(fn (callable $get) => $get('start_time') === null),
                        ]),
                ]),

            Subsection::make()
                ->title(__('appointment.section.additional'))
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
                ->title(__('appointment.section.notes'))
                ->icon('heroicon-o-annotation')
                ->schema([
                    RichEditor::make('notes')
                        ->disableLabel()
                        ->toolbarButtons(['bold', 'italic', 'strike', 'bulletList', 'orderedList', 'redo', 'undo'])
                        ->nullable()
                        ->maxLength(65535),
                ]),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('field.id'))
                    ->prefix('#')
                    ->size('sm')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('date')
                    ->label(__('field.date'))
                    ->formatStateUsing(fn (Appointment $record) => $record->date->toFormattedDate())
                    ->size('sm')
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('interval')
                    ->label(__('field.interval_hours'))
                    ->formatStateUsing(fn (Appointment $record) => $record->interval)
                    ->size('sm')
                    ->toggleable(),

                TextColumn::make('beneficiary.id')
                    ->label(__('field.beneficiary_id'))
                    ->prefix('#')
                    ->size('sm')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('beneficiary.full_name')
                    ->label(__('field.beneficiary'))
                    ->size('sm')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                // TextColumn::make('services')
                //     ->label(__('field.services'))
                //     ->size('sm')
                //     ->toggleable(),

                TextColumn::make('interventions_count')
                    ->counts('interventions')
                    ->label(__('field.associated_interventions'))
                    ->size('sm')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('location')
                    ->label(__('field.location'))
                    ->size('sm')
                    ->searchable()
                    ->toggleable(),

            ])
            ->filters([
                SelectFilter::make('beneficiary')
                    ->label(__('field.beneficiary'))
                    ->relationship('beneficiary', 'full_name')
                    ->placeholder(__('placeholder.all_beneficiaries'))
                    ->multiple(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                //
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            ServicesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\CalendarAppointments::route('/'),
            'list' => Pages\ListAppointments::route('/list'),
            'create' => Pages\CreateAppointment::route('/create'),
            'view' => Pages\ViewAppointment::route('/{record}'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
