<?php

declare(strict_types=1);

namespace App\Filament\Resources\InterventionResource\RelationManagers;

use App\Enums\Intervention\Status;
use App\Forms\Components\Radio;
use App\Tables\Columns\TextColumn;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class InterventionsRelationManager extends RelationManager
{
    protected static string $relationship = 'interventions';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getTitle(): string
    {
        return __('case.services');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('service')
                    ->relationship('service', 'name')
                    ->label(__('field.service'))
                    ->placeholder(__('placeholder.select_one'))
                    ->searchable()
                    ->preload(),

                Select::make('status')
                    ->label(__('field.status'))
                    ->options(Status::options())
                    ->enum(Status::class)
                    ->default(Status::PLANNED),

                DatePicker::make('date')
                    ->label(__('field.date'))
                    ->default(today()),

                Radio::make('integrated')
                    ->label(__('field.integrated'))
                    ->inlineOptions()
                    ->boolean()
                    ->default(0),

                Textarea::make('notes')
                    ->label(__('field.notes'))
                    ->autosize(false)
                    ->rows(4)
                    ->extraInputAttributes([
                        'class' => 'resize-none',
                    ])
                    ->columnSpanFull(),

                Checkbox::make('outside_working_hours')
                    ->label(__('field.outside_working_hours')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('field.id'))
                    ->prefix('#')
                    ->size('sm'),

                TextColumn::make('service.name')
                    ->label(__('field.name'))
                    ->size('sm'),

                TextColumn::make('status')
                    ->label(__('field.status'))
                    ->formatStateUsing(fn ($state) => __("intervention.status.$state"))
                    ->size('sm'),

                TextColumn::make('integrated')
                    ->label(__('field.integrated'))
                    ->boolean()
                    ->size('sm'),

                TextColumn::make('date')
                    ->label(__('field.date'))
                    ->date()
                    ->size('sm'),

                TextColumn::make('notes')
                    ->label(__('field.notes'))
                    ->wrap()
                    ->limit(40)
                    ->size('sm'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->icon('heroicon-o-plus-circle')
                    ->label(__('intervention.action.add_service'))
                    ->modalHeading(__('intervention.action.add_service')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->iconButton(),
                Tables\Actions\EditAction::make()
                    ->iconButton(),
                // Tables\Actions\DeleteAction::make(),
            ]);
    }
}
