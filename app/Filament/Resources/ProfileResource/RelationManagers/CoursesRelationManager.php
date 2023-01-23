<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\RelationManagers;

use App\Enums\CourseType;
use App\Models\Profile\Course;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;

class CoursesRelationManager extends RelationManager
{
    protected static string $relationship = 'courses';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('user.profile.field.courses.name'))
                    ->nullable()
                    ->maxLength(50),
                TextInput::make('theme')
                    ->label(__('user.profile.field.courses.theme'))
                    ->nullable()
                    ->maxLength(50),
                Select::make('type')
                    ->label(__('user.profile.field.courses.type'))
                    ->options(CourseType::options())
                    ->nullable(),
                TextInput::make('credits')
                    ->label(__('user.profile.field.courses.credits'))
                    ->nullable()
                    ->numeric()
                    ->maxValue(9999),
                TextInput::make('provider')
                    ->label(__('user.profile.field.courses.provider'))
                    ->columnSpanFull()
                    ->nullable()
                    ->maxLength(50),
                DatePicker::make('start_date')
                    ->label(__('user.profile.field.start_date'))
                    ->nullable(),
                DatePicker::make('end_date')
                    ->label(__('user.profile.field.end_date'))
                    ->afterOrEqual('start_date')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('end_date')
                    ->label(__('user.profile.field.year'))
                    ->formatStateUsing((fn (Course $record) => $record->end_date->format('Y')))
                    ->sortable(),
                TextColumn::make('provider')
                    ->label(__('user.profile.field.courses.provider'))
                    ->sortable(),
                TextColumn::make('name')
                    ->label(__('user.profile.field.courses.name'))
                    ->limit(30)
                    ->sortable(),
                TextColumn::make('type')
                    ->label(__('user.profile.field.courses.type'))
                    ->formatStateUsing(fn (Course $record) => __($record->type?->label())),
                TextColumn::make('credits')
                    ->label(__('user.profile.field.courses.credits'))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                ViewAction::make()
                    ->iconButton(),
                EditAction::make()
                    ->iconButton(),
                DeleteAction::make()
                    ->iconButton(),
            ]);
    }

    public static function getTitle(): string
    {
        return __('user.profile.section.courses');
    }
}
