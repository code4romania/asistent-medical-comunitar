<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries;

use App\Enums\Beneficiary\Status;
use App\Filament\Resources\Beneficiaries\Pages\CatagraphySummary;
use App\Filament\Resources\Beneficiaries\Pages\CreateBeneficiary;
use App\Filament\Resources\Beneficiaries\Pages\EditBeneficiary;
use App\Filament\Resources\Beneficiaries\Pages\ListBeneficiaries;
use App\Filament\Resources\Beneficiaries\Pages\ListHistory;
use App\Filament\Resources\Beneficiaries\Pages\ListOcasionalBeneficiaries;
use App\Filament\Resources\Beneficiaries\Pages\ListRegularBeneficiaries;
use App\Filament\Resources\Beneficiaries\Pages\OverviewBeneficiary;
use App\Filament\Resources\Beneficiaries\Pages\ViewPersonalData;
use App\Filament\Resources\Beneficiaries\Widgets\ActiveInterventionsWidget;
use App\Filament\Resources\Beneficiaries\Widgets\PersonalDataWidget;
use App\Filament\Resources\Catagraphies\Pages as CatagraphyPages;
use App\Filament\Resources\Documents\Pages as DocumentPages;
use App\Filament\Resources\Interventions\Pages as InterventionPages;
use App\Models\Beneficiary;
use App\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class BeneficiaryResource extends Resource
{
    protected static ?string $model = Beneficiary::class;

    protected static ?int $navigationSort = 1;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-m-user-group';

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
                    ->sortable(
                        query: fn (Builder $query, string $direction) => $query
                            ->orderBy('last_name', $direction)
                    )
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

                TextColumn::make('status')
                    ->label(__('field.status'))
                    ->badge()
                    ->hidden(fn (Page $livewire) => $livewire instanceof ListOcasionalBeneficiaries),

                TextColumn::make('type')
                    ->label(__('field.beneficiary_type'))
                    ->badge()
                    ->default($default)
                    ->hidden(
                        fn (Page $livewire) => is_subclass_of($livewire, ListBeneficiaries::class)
                    ),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('field.status'))
                    ->options(Status::options())
                    ->multiple(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton(),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBeneficiaries::route('/'),
            'regular' => ListRegularBeneficiaries::route('/regular'),
            'ocasional' => ListOcasionalBeneficiaries::route('/ocasional'),

            'create' => CreateBeneficiary::route('/create'),
            'view' => OverviewBeneficiary::route('/{record}'),
            'edit' => EditBeneficiary::route('/{record}/edit'),

            'personal_data' => ViewPersonalData::route('/{record}/data'),

            'catagraphy' => CatagraphySummary::route('/{record}/catagraphy'),
            'catagraphy.view' => CatagraphyPages\ViewCatagraphy::route('/{record}/catagraphy/view'),
            'catagraphy.edit' => CatagraphyPages\EditCatagraphy::route('/{record}/catagraphy/edit'),

            'interventions.index' => InterventionPages\ListInterventions::route('/{beneficiary}/interventions'),
            'interventions.view' => InterventionPages\ViewIntervention::route('/{beneficiary}/interventions/{record}'),
            'interventions.edit' => InterventionPages\EditIntervention::route('/{beneficiary}/interventions/{record}/edit'),

            'documents.index' => DocumentPages\ListDocuments::route('/{beneficiary}/documents'),
            'documents.view' => DocumentPages\ViewDocument::route('/{beneficiary}/documents/{record}'),
            'documents.edit' => DocumentPages\EditDocument::route('/{beneficiary}/documents/{record}/edit'),

            'history' => ListHistory::route('/{record}/history'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            PersonalDataWidget::class,
            ActiveInterventionsWidget::class,
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            OverviewBeneficiary::class,
            ViewPersonalData::class,
            CatagraphySummary::class,
            // InterventionPages\ListInterventions::class,
            // DocumentPages\ListDocuments::class,
            // Pages\ListHistory::class,
        ]);
    }
}
