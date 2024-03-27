<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\RelationManagers;

use App\Enums\CourseType;
use App\Filament\Tables\Columns\TextColumn;
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

class CoursesRelationManager extends RelationManager
{
    protected static string $relationship = 'courses';

    protected static function getModelLabel(): string
    {
        return __('course.label.singular');
    }

    protected static function getPluralModelLabel(): string
    {
        return __('course.label.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('field.course_name'))
                    ->placeholder(__('placeholder.course_name'))
                    ->required()
                    ->maxLength(200),

                TextInput::make('theme')
                    ->label(__('field.course_theme'))
                    ->placeholder(__('placeholder.course_theme'))
                    ->nullable()
                    ->maxLength(200),

                Select::make('type')
                    ->label(__('field.course_type'))
                    ->placeholder(__('placeholder.choose'))
                    ->options(CourseType::options())
                    ->required(),

                TextInput::make('credits')
                    ->label(__('field.course_credits'))
                    ->placeholder(__('placeholder.course_credits'))
                    ->nullable()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(9999),

                TextInput::make('provider')
                    ->label(__('field.course_provider'))
                    ->placeholder(__('placeholder.course_provider'))
                    ->columnSpanFull()
                    ->nullable()
                    ->maxLength(250),

                DatePicker::make('start_date')
                    ->label(__('field.start_date'))
                    ->placeholder(__('placeholder.choose'))
                    ->nullable(),

                DatePicker::make('end_date')
                    ->label(__('field.end_date'))
                    ->placeholder(__('placeholder.choose'))
                    ->afterOrEqual('start_date')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('end_date')
                    ->label(__('field.year'))
                    ->formatStateUsing((fn (Course $record) => $record->end_date?->format('Y')))
                    ->sortable(),

                TextColumn::make('provider')
                    ->label(__('field.course_provider'))
                    ->sortable(),

                TextColumn::make('name')
                    ->label(__('field.course_name'))
                    ->limit(30)
                    ->sortable(),

                TextColumn::make('type')
                    ->label(__('field.course_type'))
                    ->formatStateUsing(fn (Course $record) => __($record->type?->label())),

                TextColumn::make('credits')
                    ->label(__('field.course_credits'))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label(__('course.action.create')),
            ])
            ->actions([
                ViewAction::make()
                    ->iconButton(),

                EditAction::make()
                    ->label(__('course.action.edit'))
                    ->iconButton(),

                DeleteAction::make()
                    ->label(__('course.action.delete'))
                    ->iconButton(),
            ]);
    }
}
