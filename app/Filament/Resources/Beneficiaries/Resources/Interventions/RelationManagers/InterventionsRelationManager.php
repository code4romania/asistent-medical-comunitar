<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Interventions\RelationManagers;

use App\Enums\Intervention\Status;
use App\Filament\Infolists\Components\BooleanEntry;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\InterventionResource;
use App\Filament\Tables\Columns\BooleanColumn;
use App\Models\Intervention;
use App\Models\Intervention\InterventionableIndividualService;
use App\Models\Service\Service;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class InterventionsRelationManager extends RelationManager
{
    protected static string $relationship = 'interventions';

    public static function getRelationshipTitle(): string
    {
        return __('intervention.services');
    }

    public function form(Schema $schema): Schema
    {
        $services = Service::allAsFlatOptions();

        return $schema
            ->components([
                Select::make('interventionable.service_id')
                    ->label(__('field.service'))
                    ->placeholder(__('placeholder.select_one'))
                    ->options($services)
                    ->optionsLimit($services->count())
                    ->in($services->keys())
                    ->searchable()
                    ->required(),

                Select::make('interventionable.status')
                    ->label(__('field.status'))
                    ->options(Status::class)
                    ->default(Status::PLANNED)
                    ->required(),

                DatePicker::make('interventionable.date')
                    ->label(__('field.date'))
                    ->minDate(fn () => InterventionResource::minReportingDate())
                    ->default(today())
                    ->required(),

                Radio::make('integrated')
                    ->label(__('field.integrated'))
                    ->inline()
                    ->boolean()
                    ->default(0),

                Textarea::make('notes')
                    ->label(__('field.notes'))
                    ->autosize(false)
                    ->rows(4)
                    ->columnSpanFull()
                    ->extraInputAttributes([
                        'class' => 'resize-none',
                    ])
                    ->maxLength(65535),

                Checkbox::make('interventionable.outside_working_hours')
                    ->label(__('field.outside_working_hours'))
                    ->helperText(__('field.outside_working_hours_help'))
                    ->columnSpanFull(),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('interventionable.service.name')
                    ->label(__('field.service')),

                TextEntry::make('interventionable.status')
                    ->label(__('field.status')),

                TextEntry::make('interventionable.date')
                    ->label(__('field.date'))
                    ->date(),

                BooleanEntry::make('integrated')
                    ->label(__('field.integrated')),

                TextEntry::make('notes')
                    ->label(__('field.notes'))
                    ->columnSpanFull(),

                BooleanEntry::make('interventionable.outside_working_hours')
                    ->label(__('field.outside_working_hours')),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('id')
                    ->label(__('field.id'))
                    ->prefix('#'),

                TextColumn::make('interventionable.service.name')
                    ->label(__('field.service_name')),

                TextColumn::make('interventionable.status')
                    ->label(__('field.status')),

                BooleanColumn::make('integrated')
                    ->label(__('field.integrated')),

                TextColumn::make('interventionable.date')
                    ->label(__('field.date'))
                    ->date(),

                TextColumn::make('appointment.label')
                    ->label(__('field.associated_appointments'))
                    ->url(fn (?Intervention $record) => $record->appointment?->url),

                TextColumn::make('notes')
                    ->label(__('field.notes'))
                    ->wrap()
                    ->limit(40),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->icon(Heroicon::OutlinedPlusCircle)
                    ->label(__('intervention.action.add_service'))
                    ->modalHeading(__('intervention.action.add_service'))
                    ->visible(fn (self $livewire) => Auth::user()->can('update', $livewire->getOwnerRecord()))
                    ->using(function (array $data, $livewire) {
                        $interventionable = InterventionableIndividualService::create(Arr::pull($data, 'interventionable'));

                        $data['parent_id'] = $livewire->getOwnerRecord()->id;
                        $data['beneficiary_id'] = $livewire->getOwnerRecord()->beneficiary_id;

                        return $interventionable->intervention()->create($data);
                    }),

            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton(),

                EditAction::make()
                    ->iconButton()
                    ->mutateRecordDataUsing(function (array $data, Intervention $record): array {
                        $data['interventionable'] = $record->interventionable->attributesToArray();

                        return $data;
                    })
                    ->using(function (array $data, Intervention $record) {
                        $record->interventionable->update(Arr::pull($data, 'interventionable'));

                        $record->update($data);
                    })
                    ->visible(Auth::user()->can('update', $this->getOwnerRecord())),

            ])
            ->defaultSort('id', 'desc')
            ->paginated(false);
    }

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        if (! $ownerRecord->isCase()) {
            return false;
        }

        return parent::canViewForRecord($ownerRecord, $pageClass);
    }
}
