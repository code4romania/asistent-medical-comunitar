<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers\ServicesRelationManager;
use App\Filament\Resources\AppointmentResource\Schemas\AppointmentForm;
use App\Filament\Resources\AppointmentResource\Schemas\AppointmentInfolist;
use App\Models\Appointment;
use App\Tables\Columns\TextColumn;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-m-calendar-date-range';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Start;

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            // ...
            Pages\ViewAppointment::class,
            Pages\EditAppointment::class,
        ]);
    }

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
            ->schema(AppointmentForm::getSchema());
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema(AppointmentInfolist::getSchema());
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
            'create' => Pages\CreateAppointment::route('/create/{beneficiary?}'),
            'view' => Pages\ViewAppointment::route('/{record}'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
