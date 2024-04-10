<?php

declare(strict_types=1);

namespace App\Filament\Resources\InterventionResource\RelationManagers;

use App\Enums\Intervention\Status;
use App\Filament\Forms\Components\Radio;
use App\Filament\Resources\InterventionResource;
use App\Filament\Tables\Columns\TextColumn;
use App\Models\Appointment;
use App\Models\Intervention;
use App\Models\Intervention\InterventionableIndividualService;
use App\Models\Service\Service;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class InterventionsRelationManager extends RelationManager
{
    protected static string $relationship = 'interventions';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getTitle(): string
    {
        return __('intervention.services');
    }

    public static function form(Form $form): Form
    {
        $services = Service::allAsFlatOptions();

        return $form
            ->schema([
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
                    ->options(Status::options())
                    ->enum(Status::class)
                    ->default(Status::PLANNED)
                    ->required(),

                DatePicker::make('interventionable.date')
                    ->label(__('field.date'))
                    ->minDate(fn () => InterventionResource::minReportingDate())
                    ->default(today())
                    ->required(),

                Radio::make('integrated')
                    ->label(__('field.integrated'))
                    ->inlineOptions()
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
                    ->helperText(__('field.outside_working_hours_help')),
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

                TextColumn::make('interventionable.service.name')
                    ->label(__('field.service_name'))
                    ->size('sm'),

                TextColumn::make('interventionable.status')
                    ->label(__('field.status'))
                    ->formatStateUsing(fn ($state) => __("intervention.status.$state"))
                    ->size('sm'),

                TextColumn::make('integrated')
                    ->label(__('field.integrated'))
                    ->boolean()
                    ->size('sm'),

                TextColumn::make('interventionable.date')
                    ->label(__('field.date'))
                    ->date()
                    ->size('sm'),

                TextColumn::make('appointment')
                    ->label(__('field.associated_appointments'))
                    ->formatStateUsing(
                        function (?Appointment $state) {
                            if (! $state) {
                                return;
                            }

                            return Str::of($state->label)
                                ->wrap('<a href="' . $state->url . '" class="filament-link inline-flex items-center justify-center gap-0.5 font-medium outline-none hover:underline focus:underline text-primary-600 hover:text-primary-500">', '</a>')
                                ->toHtmlString();
                        }
                    )
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
                    ->modalHeading(__('intervention.action.add_service'))
                    ->using(function (array $data, $livewire) {
                        $interventionable = InterventionableIndividualService::create($data['interventionable']);

                        return $interventionable->intervention()->create([
                            'parent_id' => $livewire->getOwnerRecord()->id,
                            'beneficiary_id' => $livewire->getOwnerRecord()->beneficiary_id,
                        ]);
                    })
                    ->visible(fn ($livewire) => auth()->user()->can('update', $livewire->getOwnerRecord())),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->iconButton()
                    ->mutateRecordDataUsing(function (array $data, Intervention $record): array {
                        $data['interventionable'] = $record->interventionable->attributesToArray();

                        return $data;
                    }),

                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->mutateRecordDataUsing(function (array $data, Intervention $record): array {
                        $data['interventionable'] = $record->interventionable->attributesToArray();

                        return $data;
                    })
                    ->using(function (array $data, Intervention $record) {
                        $record->interventionable->update(Arr::pull($data, 'interventionable'));
                    })
                    ->visible(fn ($livewire) => auth()->user()->can('update', $livewire->getOwnerRecord())),
            ]);
    }

    public static function canViewForRecord(Model $ownerRecord): bool
    {
        if (! $ownerRecord->isCase()) {
            return false;
        }

        return parent::canViewForRecord($ownerRecord);
    }
}
