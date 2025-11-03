<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Filament\Resources\Beneficiaries\Resources\Interventions\InterventionResource;
use App\Models\Intervention;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class OpenCasesWidget extends TableWidget
{
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = [
        'lg' => 2,
    ];

    public static function canView(): bool
    {
        return InterventionResource::canViewAny();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(function (): Builder {
                return Intervention::query()
                    ->onlyCases()
                    ->onlyOpen()
                    ->withCount([
                        'appointments' => fn (Builder $query) => $query->countUnique(),
                        'interventions as realized_interventions_count' => fn (Builder $query) => $query->onlyRealized(),
                    ]);
            })
            ->heading(__('intervention.title.open_cases_widget'))
            ->columns([
                TextColumn::make('id')
                    ->label(__('field.id'))
                    ->prefix('#')
                    ->sortable(),

                TextColumn::make('beneficiary.full_name')
                    ->label(__('field.beneficiary'))
                    ->sortable(),

                TextColumn::make('name')
                    ->label(__('field.intervention_name')),

                TextColumn::make('realized_interventions_count')
                    ->label(__('field.services_realized'))
                    ->alignRight()
                    ->sortable(),

                TextColumn::make('appointments_count')
                    ->counts('appointment')
                    ->label(__('field.appointments'))
                    ->alignRight()
                    ->sortable(),
            ])
            ->recordUrl(
                fn (Intervention $record) => InterventionResource::getUrl('view', [
                    'beneficiary' => $record->beneficiary_id,
                    'record' => $record,
                ])
            )
            ->defaultSort('id', 'desc')
            ->queryStringIdentifier('cases')
            ->paginated([10]);
    }
}
