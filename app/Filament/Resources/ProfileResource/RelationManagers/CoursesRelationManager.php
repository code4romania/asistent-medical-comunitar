<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\RelationManagers;

use App\Enums\CourseType;
use App\Models\Profile\Course;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class CoursesRelationManager extends RelationManager
{
    protected static string $relationship = 'courses';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('user.profile.field.courses.name'))
                    ->nullable()
                    ->maxLength(50),
                Forms\Components\TextInput::make('theme')
                    ->label(__('user.profile.field.courses.theme'))
                    ->nullable()
                    ->maxLength(50),
                Forms\Components\Select::make('type')
                    ->label(__('user.profile.field.courses.type'))
                    ->nullable()
                    ->options(CourseType::options()),
                Forms\Components\TextInput::make('credits')
                    ->label(__('user.profile.field.courses.credits'))
                    ->nullable()
                    ->numeric()
                    ->maxValue(9999),
                Forms\Components\TextInput::make('provider')
                    ->label(__('user.profile.field.courses.provider'))
                    ->nullable()
                    ->columnSpanFull()
                    ->maxLength(50),
                Forms\Components\DatePicker::make('start_date')
                    ->label(__('user.profile.field.start_date'))
                    ->nullable(),
                Forms\Components\DatePicker::make('end_date')
                    ->label(__('user.profile.field.end_date'))
                    ->afterOrEqual('start_date')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('end_date')
                    ->label(__('user.profile.field.year'))
                    ->formatStateUsing((fn (Course $record) => $record->end_date->format('Y')))
                    ->sortable(),
                Tables\Columns\TextColumn::make('provider')
                    ->label(__('user.profile.field.courses.provider'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('user.profile.field.courses.name'))
                    ->limit(30)
                    ->sortable(),
                Tables\Columns\TextColumn::make('credits')
                    ->label(__('user.profile.field.courses.credits'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('user.profile.field.courses.type'))
                    ->formatStateUsing(fn (Course $record) => __($record->type->label())),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->iconButton(),
                Tables\Actions\EditAction::make()
                    ->iconButton(),
                Tables\Actions\DeleteAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getTitle(): string
    {
        return __('user.profile.section.courses');
    }
}
