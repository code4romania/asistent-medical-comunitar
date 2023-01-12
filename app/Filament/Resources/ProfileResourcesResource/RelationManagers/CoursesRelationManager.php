<?php

namespace App\Filament\Resources\ProfileResourcesResource\RelationManagers;

use App\Enums\CourseType;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class CoursesRelationManager extends RelationManager
{
    protected static string $relationship = 'courses';

    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $title = 'user.profile.studies_page.courses';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('year')
                    ->label(__('user.profile.studies_page.year'))
                    ->options(self::generateYears())
                    ->required(),
                Forms\Components\TextInput::make('provider')
                    ->label(__('user.profile.studies_page.provider'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->label(__('user.profile.studies_page.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->label(__('user.profile.studies_page.type_courses'))
                    ->required()
                ->options(self::getTypes()),
                Forms\Components\DatePicker::make('start_date')
                    ->label(__('user.profile.studies_page.start_date'))
                    ->nullable(),
                Forms\Components\DatePicker::make('end_date')
                    ->label(__('user.profile.studies_page.end_date'))
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('year')
                    ->label(__('user.profile.studies_page.year')),
                Tables\Columns\TextColumn::make('provider')
                    ->label(__('user.profile.studies_page.provider')),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('user.profile.studies_page.name')),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('user.profile.studies_page.type_courses'))
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    private static function generateYears(): array
    {
        $years = [];
        for ($i = 1950; $i < now()->year; $i++) {
            $years[$i] = $i;
        }
        return $years;
    }

    private static function getTypes(): array
    {
        return  collect(CourseType::values())
            ->mapWithKeys(fn ($type) => [$type => __('user.profile.studies_page.' . $type)
            ])->toArray();
    }
}
