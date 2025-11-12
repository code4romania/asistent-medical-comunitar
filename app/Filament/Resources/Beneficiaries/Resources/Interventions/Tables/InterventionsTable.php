<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Interventions\Tables;

use App\Enums\Intervention\Status;
use App\Filament\Resources\Beneficiaries\Resources\Catagraphies\CatagraphyResource;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\Actions\CreateCaseAction;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\Actions\CreateIndividualServiceAction;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class InterventionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query): Builder {
                return $query
                    ->withCount([
                        'interventions',
                        'interventions as realized_interventions_count' => fn (Builder $query) => $query->onlyRealized(),
                    ]);
            })
            ->columns([
                TextColumn::make('id')
                    ->label(__('field.id'))
                    ->prefix('#'),

                TextColumn::make('name')
                    ->label(__('field.service_name'))
                    ->wrap(),

                TextColumn::make('vulnerability.name')
                    ->label(__('field.vulnerability'))
                    ->toggleable()
                    ->wrap(),

                TextColumn::make('type')
                    ->label(__('field.type')),

                TextColumn::make('status')
                    ->label(__('field.status'))
                    ->badge(),

                TextColumn::make('services')
                    ->label(__('field.services_realized'))
                    ->alignEnd(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label(__('field.type'))
                    ->multiple(),

                SelectFilter::make('status')
                    ->label(__('field.status'))
                    ->options(Status::options())
                    ->multiple(),

                SelectFilter::make('vulnerability')
                    ->label(__('field.vulnerability'))
                    ->relationship('vulnerability', 'name')
                    ->searchable()
                    ->multiple()
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton(),
            ])
            ->groups([
                Group::make('vulnerability.name')
                    ->label(__('field.vulnerability')),
            ])
            ->emptyStateActions([
                Action::make('catagraphy')
                    ->label(__('catagraphy.vulnerability.empty.create'))
                    ->hidden(fn (Page $livewire) => $livewire->getRecord()->hasCatagraphy())
                    ->url(fn (Page $livewire) => CatagraphyResource::getUrl('edit', [
                        'beneficiary' => $livewire->getRecord(),
                    ]))
                    ->color('gray')
                    ->button(),

                CreateIndividualServiceAction::make()
                    ->hidden(fn (Page $livewire) => ! $livewire->getRecord()->hasCatagraphy())
                    ->color('gray'),

                CreateCaseAction::make()
                    ->hidden(fn (Page $livewire) => ! $livewire->getRecord()->hasCatagraphy())
                    ->color('gray'),
            ])
            ->defaultSort('id', 'desc');
    }
}
