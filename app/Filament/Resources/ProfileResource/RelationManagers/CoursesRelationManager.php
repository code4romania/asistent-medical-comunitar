<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\RelationManagers;

use App\Enums\CourseType;
use App\Services\Helper;
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
                    ->options(Helper::generateYearsOptions())
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
                    ->options(CourseType::options()),
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
                    ->label(__('user.profile.studies_page.type_courses')),
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
}
