<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Forms\Components\Subsection;
use App\Models\Appointment;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

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
                Subsection::make()
                    ->title(__('appointment.section.mandatory'))
                    ->icon('heroicon-o-document-text')
                    ->columns(2)
                    ->schema([
                        Select::make('beneficiary_id')
                            ->label(__('field.beneficiary'))
                            ->relationship('beneficiary', 'full_name')
                            ->searchable()
                            ->preload(),
                    ]),

                Subsection::make()
                    ->title(__('appointment.section.mandatory'))
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        TextInput::make('type')
                            ->label(__('field.type'))
                            ->nullable()
                            ->maxLength(100),

                        TextInput::make('location')
                            ->label(__('field.location'))
                            ->nullable()
                            ->maxLength(100),

                        TextInput::make('attendant')
                            ->label(__('field.attendant'))
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
