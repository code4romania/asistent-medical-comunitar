<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Schemas;

use App\Enums\CourseType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                    ->options(CourseType::class)
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
}
