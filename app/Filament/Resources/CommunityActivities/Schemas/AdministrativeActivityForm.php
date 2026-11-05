<?php

declare(strict_types=1);

namespace App\Filament\Resources\CommunityActivities\Schemas;

use App\Enums\CommunityActivity\Administrative;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class AdministrativeActivityForm
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
                            ->options(Administrative::class)
                            ->required(),

                        Select::make('nurse_id')
                            ->label(__('field.nurse'))
                            ->placeholder(__('placeholder.choose'))
                            ->relationship(
                                'nurse',
                                'full_name',
                                fn (Builder $query) => $query->activatesInCurrentUserCounty()
                            )
                            ->searchable()
                            ->preload()
                            ->visible(fn (): bool => auth()->user()->isMediator()),

                        Select::make('mediator_id')
                            ->label(__('field.mediator'))
                            ->placeholder(__('placeholder.choose'))
                            ->relationship(
                                'mediator',
                                'full_name',
                                fn (Builder $query) => $query->activatesInCurrentUserCounty()
                            )
                            ->searchable()
                            ->preload()
                            ->visible(fn (): bool => auth()->user()->isNurse()),
                    ]),

                TextInput::make('name')
                    ->label(__('field.activity'))
                    ->placeholder(__('placeholder.activity'))
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
