<?php

declare(strict_types=1);

namespace App\Filament\Resources\CommunityActivities\Schemas;

use App\Enums\CommunityActivity\Campaign;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class CampaignForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns()
            ->components([
                Grid::make()
                    ->columnSpanFull()
                    ->schema([
                        Select::make('subtype')
                            ->label(__('field.type'))
                            ->options(Campaign::class)
                            ->required(),
                    ]),

                TextInput::make('name')
                    ->label(__('field.activity'))
                    ->placeholder(__('placeholder.activity'))
                    ->maxLength(200)
                    ->required(),

                TextInput::make('organizer')
                    ->label(__('field.organizer'))
                    ->placeholder(__('placeholder.organizer'))
                    ->maxLength(200)
                    ->required(),

                TextInput::make('location')
                    ->label(__('field.location'))
                    ->placeholder(__('placeholder.location'))
                    ->maxLength(200)
                    ->required(),

                Group::make([
                    DatePicker::make('date')
                        ->label(__('field.date'))
                        ->placeholder('zz / ll / aaaa')
                        ->required(),

                    Checkbox::make('outside_working_hours')
                        ->label(__('field.outside_working_hours'))
                        ->helperText(__('field.outside_working_hours_help')),
                ]),

                TextInput::make('participants')
                    ->label(__('field.participants'))
                    ->placeholder(__('placeholder.participants'))
                    ->maxValue(65535)
                    ->minValue(0)
                    ->required()
                    ->integer(),

                TextInput::make('roma_participants')
                    ->label(__('field.roma_participants'))
                    ->placeholder(__('placeholder.participants'))
                    ->maxValue(65535)
                    ->minValue(0)
                    ->integer(),

                SpatieMediaLibraryFileUpload::make('participants_list')
                    ->label(__('field.participants_list'))
                    ->collection('participants_list')
                    ->maxSize(1024 * 1024 * 2)
                    ->columnSpanFull(),

                Textarea::make('notes')
                    ->label(__('field.notes'))
                    ->columnSpanFull()
                    ->maxLength(65535)
                    ->autosize(false)
                    ->rows(4)
                    ->extraInputAttributes([
                        'class' => 'resize-none',
                    ]),
            ]);
    }
}
