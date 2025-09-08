<?php

declare(strict_types=1);

namespace App\Filament\Resources\CommunityActivities;

use App\Filament\Resources\CommunityActivities\Pages\ManageCampaigns;
use App\Filament\Resources\CommunityActivities\Pages\ManageAdministrativeActivities;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use App\Enums\CommunityActivity\Administrative;
use App\Enums\CommunityActivity\Campaign;
use App\Filament\Resources\CommunityActivityResource\Pages;
use App\Forms\Components\FileList;
use App\Forms\Components\Value;
use App\Models\CommunityActivity;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;

class CommunityActivityResource extends Resource
{
    protected static ?string $model = CommunityActivity::class;

    protected static ?int $navigationSort = 2;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-m-megaphone';

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
            'index' => ManageCampaigns::route('/'),
            'administrative' => ManageAdministrativeActivities::route('/administrative'),
        ];
    }

    public static function getCampaignEditFormSchema(): array
    {
        return [
            Grid::make(2)
                ->schema([
                    Grid::make()
                        ->schema([
                            Select::make('subtype')
                                ->label(__('field.type'))
                                ->options(Campaign::options())
                                ->enum(Campaign::class)
                                ->required(),
                        ]),

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
                            ->label(__('field.outside_working_hours'))
                            ->helperText(__('field.outside_working_hours_help')),
                    ]),

                    TextInput::make('participants')
                        ->label(__('field.participants'))
                        ->placeholder(__('placeholder.participants'))
                        ->required()
                        ->integer()
                        ->minValue(0)
                        ->maxValue(65535),

                    TextInput::make('roma_participants')
                        ->label(__('field.roma_participants'))
                        ->placeholder(__('placeholder.participants'))
                        ->integer()
                        ->minValue(0)
                        ->maxValue(65535),

                    SpatieMediaLibraryFileUpload::make('participants_list')
                        ->label(__('field.participants_list'))
                        ->collection('participants_list')
                        ->maxSize(1024 * 1024 * 2)
                        ->columnSpanFull(),

                    Textarea::make('notes')
                        ->label(__('field.notes'))
                        ->autosize(false)
                        ->rows(4)
                        ->columnSpanFull()
                        ->extraInputAttributes([
                            'class' => 'resize-none',
                        ])
                        ->maxLength(65535),
                ]),
        ];
    }

    public static function getCampaignViewFormSchema(): array
    {
        return [
            Grid::make(2)
                ->schema([
                    Value::make('subtype')
                        ->label(__('field.type'))
                        ->columnSpanFull(),

                    Value::make('name')
                        ->label(__('field.activity')),

                    Value::make('organizer')
                        ->label(__('field.organizer')),

                    Value::make('county')
                        ->label(__('field.county'))
                        ->content(fn (CommunityActivity $record) => $record->nurse->activityCounty?->name)
                        ->visible(fn () => auth()->user()->isAdmin()),

                    Value::make('location')
                        ->label(__('field.location')),

                    Group::make([
                        Value::make('date')
                            ->label(__('field.date')),

                        Value::make('outside_working_hours')
                            ->label(__('field.outside_working_hours'))
                            ->boolean(),
                    ]),

                    Value::make('participants')
                        ->label(__('field.participants')),

                    Value::make('roma_participants')
                        ->label(__('field.roma_participants')),

                    FileList::make('participants_list')
                        ->label(__('field.participants_list'))
                        ->collection('participants_list')
                        ->columnSpanFull(),

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
                    Grid::make()
                        ->schema([
                            Select::make('subtype')
                                ->label(__('field.type'))
                                ->options(Administrative::options())
                                ->enum(Administrative::class)
                                ->required(),
                        ]),

                    TextInput::make('name')
                        ->label(__('field.activity'))
                        ->placeholder(__('placeholder.activity'))
                        ->required()
                        ->maxLength(200),

                    Group::make([
                        DatePicker::make('date')
                            ->label(__('field.date'))
                            ->placeholder('zz / ll / aaaa')
                            ->required(),

                        Checkbox::make('outside_working_hours')
                            ->label(__('field.outside_working_hours'))
                            ->helperText(__('field.outside_working_hours_help')),
                    ]),

                    Textarea::make('notes')
                        ->label(__('field.notes'))
                        ->autosize(false)
                        ->rows(4)
                        ->columnSpanFull()
                        ->extraInputAttributes([
                            'class' => 'resize-none',
                        ])
                        ->maxLength(65535),
                ]),
        ];
    }

    public static function getAdministrativeViewFormSchema(): array
    {
        return [
            Grid::make(2)
                ->schema([
                    Value::make('subtype')
                        ->label(__('field.type'))
                        ->columnSpanFull(),

                    Value::make('name')
                        ->label(__('field.activity')),

                    Value::make('county')
                        ->label(__('field.county'))
                        ->content(fn (CommunityActivity $record) => $record->nurse->activityCounty?->name)
                        ->visible(fn () => auth()->user()->isAdmin()),

                    Group::make([
                        Value::make('date')
                            ->label(__('field.date')),

                        Value::make('outside_working_hours')
                            ->label(__('field.outside_working_hours'))
                            ->boolean(),
                    ]),

                    Value::make('notes')
                        ->label(__('field.notes'))
                        ->columnSpanFull(),
                ]),
        ];
    }
}
