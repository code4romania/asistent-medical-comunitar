<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Forms\Components\ServiceList;
use App\Filament\Forms\Components\Value;
use App\Filament\Forms\Components\VulnerabilityChips;
use App\Filament\Resources\RecommendationResource\Pages;
use App\Filament\Tables\Columns\TextColumn;
use App\Models\Recommendation;
use App\Models\Vulnerability\Vulnerability;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class RecommendationResource extends Resource
{
    protected static ?string $model = Recommendation::class;

    protected static ?int $navigationSort = 4;

    public static function getModelLabel(): string
    {
        return __('recommendation.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('recommendation.label.plural');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with('vulnerabilities.category');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                TextInput::make('title')
                    ->label(__('field.recommendation_title'))
                    ->required(),

                Textarea::make('description')
                    ->label(__('field.recommendation_description'))
                    ->nullable(),

                Select::make('vulnerabilities')
                    ->label(__('field.recommendation_vulnerabilities'))
                    ->relationship('vulnerabilities', 'name', fn (Builder $query) => $query->with('category'))
                    ->getOptionLabelFromRecordUsing(fn (Vulnerability $record) => $record->name_with_category)
                    ->preload()
                    ->optionsLimit(100)
                    ->multiple()
                    ->required(),

                Select::make('services')
                    ->label(__('field.recommendation_services'))
                    ->relationship('services', 'name')
                    ->preload()
                    ->optionsLimit(100)
                    ->multiple()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('field.id'))
                    ->prefix('#')
                    ->size('sm')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('title')
                    ->label(__('field.recommendation_title'))
                    ->size('sm')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TagsColumn::make('vulnerabilities.name')
                    ->label(__('field.recommendation_vulnerabilities'))
                    ->getStateUsing(
                        fn (Recommendation $record) => $record->vulnerabilities
                            ->pluck('name_with_category')
                            ->all()
                    )
                    ->limit(3),

                TagsColumn::make('services.name')
                    ->label(__('field.recommendation_services'))
                    ->limit(),
            ])
            ->filters([
                SelectFilter::make('vulnerabilities')
                    ->label(__('field.recommendation_vulnerabilities'))
                    ->relationship('vulnerabilities', 'name')
                    ->multiple(),

                SelectFilter::make('services')
                    ->label(__('field.recommendation_services'))
                    ->relationship('services', 'name')
                    ->multiple(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->modalHeading(fn (Recommendation $record) => $record->title)
                    ->form(static::getViewFormSchema())
                    ->iconButton(),

                Tables\Actions\EditAction::make()
                    ->iconButton(),

                Tables\Actions\DeleteAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                //
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageRecommendations::route('/'),
        ];
    }

    public static function getViewFormSchema(): array
    {
        return [
            Value::make('description')
                ->disableLabel(),

            VulnerabilityChips::make('vulnerabilities')
                ->label(__('field.recommendation_vulnerabilities')),

            ServiceList::make('services.name')
                ->label(__('field.recommendation_services'))
                ->loadStateFromRelationshipsUsing(function (ServiceList $component) {
                    $component->state(
                        $component->getModelInstance()->services->pluck('name')
                    );
                }),
        ];
    }
}
