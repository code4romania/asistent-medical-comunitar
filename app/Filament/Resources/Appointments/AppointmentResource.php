<?php

declare(strict_types=1);

namespace App\Filament\Resources\Appointments;

use App\Filament\Resources\Appointments\Pages\CalendarAppointments;
use App\Filament\Resources\Appointments\Pages\CreateAppointment;
use App\Filament\Resources\Appointments\Pages\EditAppointment;
use App\Filament\Resources\Appointments\Pages\ListAppointments;
use App\Filament\Resources\Appointments\Pages\ViewAppointment;
use App\Filament\Resources\Appointments\RelationManagers\InterventionsRelationManager;
use App\Filament\Resources\Appointments\Schemas\AppointmentForm;
use App\Filament\Resources\Appointments\Schemas\AppointmentInfolist;
use App\Filament\Resources\Appointments\Tables\AppointmentsTable;
use App\Models\Appointment;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

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

    public static function form(Schema $schema): Schema
    {
        return AppointmentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AppointmentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AppointmentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            InterventionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => CalendarAppointments::route('/'),
            'list' => ListAppointments::route('/list'),
            'create' => CreateAppointment::route('/create'),
            'view' => ViewAppointment::route('/{record}'),
            'edit' => EditAppointment::route('/{record}/edit'),
        ];
    }
}
