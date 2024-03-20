<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Forms\Components\FileList;
use App\Filament\Forms\Components\Value;
use App\Filament\Resources\CommunityActivityResource\Pages;
use App\Models\CommunityActivity;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;

class CommunityActivityResource extends Resource
{
    protected static ?string $model = CommunityActivity::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $slug = 'community';

    public static function getModelLabel(): string
    {
        return __('community_activity.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('community_activity.label.plural');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCampaigns::route('/'),
            'administrative' => Pages\ManageAdministrativeActivities::route('/administrative'),
        ];
    }

    public static function getCampaignEditFormSchema(): array
    {
        return [
            Grid::make(2)
                ->schema([
                    TextInput::make('name')
                        ->label(__('field.activity'))
                        ->placeholder(__('placeholder.activity'))
                        ->required()
                        ->maxLength(200),

                    TextInput::make('organizer')
                        ->label(__('field.organizer'))
                        ->placeholder(__('placeholder.organizer'))
                        ->required()
                        ->maxLength(200),

                    Select::make('county_id')
                        ->label(__('field.county'))
                        ->placeholder(__('placeholder.county'))
                        ->relationship('county', 'name')
                        ->required()
                        ->visible(fn () => auth()->user()->isAdmin()),

                    TextInput::make('location')
                        ->label(__('field.location'))
                        ->placeholder(__('placeholder.location'))
                        ->required()
                        ->maxLength(200),

                    Group::make([
                        DatePicker::make('date')
                            ->label(__('field.date'))
                            ->placeholder('zz / ll / aaaa')
                            ->required(),

                        Checkbox::make('outside_working_hours')
                            ->label(__('field.outside_working_hours')),
                    ]),

                    TextInput::make('participants')
                        ->label(__('field.participants'))
                        ->placeholder(__('placeholder.participants'))
                        ->required()
                        ->integer()
                        ->minValue(0)
                        ->maxValue(65535),

                    SpatieMediaLibraryFileUpload::make('participants_list')
                        ->label(__('field.participants_list'))
                        ->collection('participants_list')
                        ->maxSize(1024 * 1024 * 2),

                    Textarea::make('notes')
                        ->label(__('field.notes'))
                        ->autosize(false)
                        ->rows(4)
                        ->columnSpanFull()
                        ->extraInputAttributes([
                            'class' => 'resize-none',
                        ])
                        ->columnSpanFull(),
                ]),
        ];
    }

    public static function getCampaignViewFormSchema(): array
    {
        return [
            Grid::make(2)
                ->schema([
                    Value::make('name')
                        ->label(__('field.activity')),

                    Value::make('organizer')
                        ->label(__('field.organizer')),

                    Value::make('county')
                        ->label(__('field.county'))
                        ->content(fn ($record) => $record->county?->name)
                        ->visible(fn () => auth()->user()->isAdmin()),

                    Value::make('location')
                        ->label(__('field.location')),

                    Group::make([
                        Value::make('date')
                            ->label(__('field.date')),

                        Checkbox::make('outside_working_hours')
                            ->label(__('field.outside_working_hours')),
                    ]),

                    Value::make('participants')
                        ->label(__('field.participants')),

                    FileList::make('participants_list')
                        ->label(__('field.participants_list'))
                        ->collection('participants_list'),

                    Value::make('notes')
                        ->label(__('field.notes'))
                        ->columnSpanFull(),
                ]),
        ];
    }

    public static function getAdministrativeEditFormSchema(): array
    {
        return [
            Grid::make(2)
                ->schema([
                    TextInput::make('name')
                        ->label(__('field.activity'))
                        ->placeholder(__('placeholder.activity'))
                        ->required()
                        ->maxLength(200),

                    Select::make('county_id')
                        ->label(__('field.county'))
                        ->placeholder(__('placeholder.county'))
                        ->relationship('county', 'name')
                        ->required()
                        ->visible(fn () => auth()->user()->isAdmin()),

                    Group::make([
                        DatePicker::make('date')
                            ->label(__('field.date'))
                            ->placeholder('zz / ll / aaaa')
                            ->required(),

                        Checkbox::make('outside_working_hours')
                            ->label(__('field.outside_working_hours')),
                    ]),

                    Textarea::make('notes')
                        ->label(__('field.notes'))
                        ->autosize(false)
                        ->rows(4)
                        ->columnSpanFull()
                        ->extraInputAttributes([
                            'class' => 'resize-none',
                        ])
                        ->columnSpanFull(),
                ]),
        ];
    }

    public static function getAdministrativeViewFormSchema(): array
    {
        return [
            Grid::make(2)
                ->schema([
                    Value::make('name')
                        ->label(__('field.activity')),

                    Value::make('county')
                        ->label(__('field.county'))
                        ->content(fn ($record) => $record->county?->name)
                        ->visible(fn () => auth()->user()->isAdmin()),

                    Group::make([
                        Value::make('date')
                            ->label(__('field.date')),

                        Checkbox::make('outside_working_hours')
                            ->label(__('field.outside_working_hours')),
                    ]),

                    Value::make('notes')
                        ->label(__('field.notes'))
                        ->columnSpanFull(),
                ]),
        ];
    }
}
