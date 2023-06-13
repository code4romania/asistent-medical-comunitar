<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\Intervention\CaseInitiator;
use App\Enums\Intervention\Status;
use App\Filament\Resources\InterventionResource\Pages;
use App\Filament\Resources\InterventionResource\RelationManagers\InterventionsRelationManager;
use App\Forms\Components\Radio;
use App\Forms\Components\Subsection;
use App\Models\Intervention;
use App\Models\Service\Service;
use App\Models\Vulnerability\Vulnerability;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;

class InterventionResource extends Resource
{
    protected static ?string $model = Intervention::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static bool $shouldRegisterNavigation = false;

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageInterventions::route('/'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            InterventionsRelationManager::class,
        ];
    }

    public static function getCaseFormSchema(int $columns = 2): array
    {
        $vulnerabilities = Vulnerability::cachedList()
            ->pluck('name', 'id');

        return [
            Subsection::make()
                ->icon('heroicon-o-document-text')
                ->columns(2)
                ->columnSpan([
                    'lg' => $columns - 1,
                ])
                ->schema([
                    TextInput::make('interventionable.name')
                        ->label(__('field.intervention_name'))
                        ->columnSpanFull(),

                    Select::make('interventionable.initiator')
                        ->label(__('field.initiator'))
                        ->placeholder(__('placeholder.choose'))
                        ->options(CaseInitiator::options())
                        ->enum(CaseInitiator::class)
                        ->default(CaseInitiator::NURSE)
                        ->required(),

                    Select::make('vulnerability')
                        ->relationship('vulnerability', 'name')
                        ->label(__('field.addressed_vulnerability'))
                        ->placeholder(__('placeholder.select_one'))
                        ->options($vulnerabilities)
                        ->in($vulnerabilities->keys())
                        ->searchable()
                        ->required(),

                    Radio::make('integrated')
                        ->label(__('field.integrated'))
                        ->inlineOptions()
                        ->boolean()
                        ->default(0),
                ]),

            Subsection::make()
                ->icon('heroicon-o-annotation')
                ->columnSpan([
                    'lg' => 1,
                ])
                ->schema([
                    Textarea::make('notes')
                        ->label(__('field.notes')),
                ]),
        ];
    }

    public static function getIndividualServiceFormSchema(): array
    {
        $vulnerabilities = Vulnerability::cachedList()
            ->pluck('name', 'id');

        $services = Service::cachedList()
            ->pluck('name', 'id');

        return [
            Grid::make(2)
                ->schema([
                    Select::make('interventionable.service_id')
                        ->label(__('field.service'))
                        ->placeholder(__('placeholder.select_one'))
                        ->options($services)
                        ->in($services->keys())
                        ->searchable(),

                    Select::make('vulnerability')
                        ->relationship('vulnerability', 'name')
                        ->label(__('field.addressed_vulnerability'))
                        ->placeholder(__('placeholder.select_one'))
                        ->options($vulnerabilities)
                        ->in($vulnerabilities->keys())
                        ->searchable(),

                    Select::make('interventionable.status')
                        ->label(__('field.status'))
                        ->options(Status::options())
                        ->enum(Status::class)
                        ->default(Status::PLANNED),

                    DatePicker::make('interventionable.date')
                        ->label(__('field.date')),

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

                    Checkbox::make('interventionable.outside_working_hours')
                        ->label(__('field.outside_working_hours')),
                ]),
        ];
    }
}
