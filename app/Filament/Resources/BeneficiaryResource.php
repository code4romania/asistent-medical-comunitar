<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\Beneficiary\Status;
use App\Enums\Beneficiary\Type;
use App\Filament\Resources\BeneficiaryResource\Pages;
use App\Filament\Resources\CatagraphyResource\Pages as CatagraphyPages;
use App\Filament\Resources\InterventionResource\Pages as InterventionPages;
use App\Models\Beneficiary;
use App\Tables\Columns\BadgeColumn;
use App\Tables\Columns\TextColumn;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class BeneficiaryResource extends Resource
{
    protected static ?string $model = Beneficiary::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'full_name';

    public static function getModelLabel(): string
    {
        return __('beneficiary.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('beneficiary.label.plural');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withLocation();
    }

    public static function table(Table $table): Table
    {
        $default = new HtmlString('&mdash;');

        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('field.id'))
                    ->prefix('#')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('first_name')
                    ->label(__('field.first_name'))
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->default($default),

                TextColumn::make('last_name_with_prior')
                    ->label(__('field.last_name'))
                    ->sortable()
                    ->searchable(
                        query: fn (Builder $query, string $search) => $query
                            ->where('last_name', 'like', "%{$search}%")
                            ->orWhere('prior_name', 'like', "%{$search}%")
                    )
                    ->toggleable()
                    ->default($default),

                TextColumn::make('cnp')
                    ->label(__('field.cnp'))
                    ->searchable()
                    ->toggleable()
                    ->default($default),

                TextColumn::make('age')
                    ->label(__('field.age'))
                    ->toggleable()
                    ->default($default),

                TextColumn::make('city.name')
                    ->label(__('field.city'))
                    ->description(fn (Beneficiary $record) => $record->county?->name)
                    ->toggleable()
                    ->default($default),

                BadgeColumn::make('status')
                    ->label(__('field.status'))
                    ->enum(Status::options())
                    ->colors(Status::flipColors())
                    ->default($default),

                BadgeColumn::make('type')
                    ->label(__('field.beneficiary_type'))
                    ->enum(Type::options())
                    ->colors(Type::flipColors())
                    ->default($default)
                    ->hidden(
                        fn ($livewire) => is_subclass_of($livewire, Pages\ListBeneficiaries::class)
                    ),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('field.status'))
                    ->options(Status::options())
                    ->multiple(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->iconButton(),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBeneficiaries::route('/'),
            'regular' => Pages\ListRegularBeneficiaries::route('/regular'),
            'ocasional' => Pages\ListOcasionalBeneficiaries::route('/ocasional'),

            'create' => Pages\CreateBeneficiary::route('/create'),
            'view' => Pages\OverviewBeneficiary::route('/{record}'),
            'edit' => Pages\EditBeneficiary::route('/{record}/edit'),

            'personal_data' => Pages\ViewPersonalData::route('/{record}/data'),

            'catagraphy' => Pages\CatagraphySummary::route('/{record}/catagraphy'),
            'catagraphy.view' => CatagraphyPages\ViewCatagraphy::route('/{record}/catagraphy/view'),
            'catagraphy.edit' => CatagraphyPages\EditCatagraphy::route('/{record}/catagraphy/edit'),

            'interventions.index' => InterventionPages\ListInterventions::route('/{beneficiary}/interventions'),
            'interventions.view' => InterventionPages\ViewIntervention::route('/{beneficiary}/interventions/{record}'),
            'interventions.edit' => InterventionPages\EditIntervention::route('/{beneficiary}/interventions/{record}/edit'),

            'history' => Pages\ListHistory::route('/{record}/history'),
        ];
    }
}
