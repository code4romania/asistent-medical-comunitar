<?php

declare(strict_types=1);

namespace App\Filament\Resources\InterventionResource\RelationManagers;

use App\Enums\Intervention\Status;
use App\Forms\Components\Radio;
use App\Models\Intervention;
use App\Models\Intervention\InterventionableIndividualService;
use App\Models\Service\Service;
use App\Tables\Columns\TextColumn;
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
        $services = Service::cachedList()
            ->pluck('name', 'id');

        return $form
            ->schema([
                Select::make('interventionable.service_id')
                    ->label(__('field.service'))
                    ->placeholder(__('placeholder.select_one'))
                    ->searchable()
                    ->options($services)
                    ->in($services->keys()),

                Select::make('interventionable.status')
                    ->label(__('field.status'))
                    ->options(Status::options())
                    ->enum(Status::class)
                    ->default(Status::PLANNED),

                DatePicker::make('interventionable.date')
                    ->label(__('field.date'))
                    ->default(today()),

                Radio::make('interventionable.integrated')
                    ->label(__('field.integrated'))
                    ->inlineOptions()
                    ->boolean()
                    ->default(0),

                Textarea::make('interventionable.notes')
                    ->label(__('field.notes'))
                    ->autosize(false)
                    ->rows(4)
                    ->extraInputAttributes([
                        'class' => 'resize-none',
                    ])
                    ->columnSpanFull(),

                Checkbox::make('interventionable.outside_working_hours')
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

                TextColumn::make('interventionable.service.name')
                    ->label(__('field.name'))
                    ->size('sm'),

                TextColumn::make('interventionable.status')
                    ->label(__('field.status'))
                    ->formatStateUsing(fn ($state) => __("intervention.status.$state"))
                    ->size('sm'),

                TextColumn::make('interventionable.integrated')
                    ->label(__('field.integrated'))
                    ->boolean()
                    ->size('sm'),

                TextColumn::make('interventionable.date')
                    ->label(__('field.date'))
                    ->date()
                    ->size('sm'),

                TextColumn::make('interventionable.notes')
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
                        ]);
                    }),
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
                    }),
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
