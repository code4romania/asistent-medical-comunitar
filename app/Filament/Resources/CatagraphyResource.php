<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\Vulnerability\AgeCategory;
use App\Enums\Vulnerability\DomesticViolence;
use App\Enums\Vulnerability\Education;
use App\Enums\Vulnerability\Family;
use App\Enums\Vulnerability\Habitation;
use App\Enums\Vulnerability\IDType;
use App\Enums\Vulnerability\Income;
use App\Enums\Vulnerability\Poverty;
use App\Forms\Components\Card;
use App\Forms\Components\Subsection;
use App\Models\Catagraphy;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CatagraphyResource extends Resource
{
    protected static ?string $model = Catagraphy::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Card::make()
                    ->schema([
                        Subsection::make()
                            ->icon('heroicon-o-information-circle')
                            ->columns(2)
                            ->schema([
                                DatePicker::make('evaluation_date'),

                                Select::make('nurse_id')
                                    ->label(__('field.nurse'))
                                    ->relationship('nurse', 'full_name', fn (Builder $query) => $query->onlyNurses())
                                    ->searchable()
                                    ->preload(),
                            ]),

                        Subsection::make()
                            ->icon('heroicon-o-presentation-chart-bar')
                            ->columns(2)
                            ->schema([
                                Select::make('id_type')
                                    ->label(__('field.id_type'))
                                    ->placeholder(__('placeholder.select_one'))
                                    ->options(IDType::options())
                                    ->enum(IDType::class)
                                    ->searchable(),

                                Select::make('age_category')
                                    ->label(__('field.age_category'))
                                    ->placeholder(__('placeholder.select_one'))
                                    ->options(AgeCategory::options())
                                    ->enum(AgeCategory::class)
                                    ->searchable(),

                                Select::make('income')
                                    ->label(__('field.income'))
                                    ->placeholder(__('placeholder.select_one'))
                                    ->options(Income::options())
                                    ->enum(Income::class)
                                    ->searchable(),

                                Select::make('poverty')
                                    ->label(__('field.poverty'))
                                    ->placeholder(__('placeholder.select_one'))
                                    ->options(Poverty::options())
                                    ->enum(Poverty::class)
                                    ->searchable(),

                                Select::make('habitation')
                                    ->label(__('field.habitation'))
                                    ->placeholder(__('placeholder.select_many'))
                                    ->options(Habitation::options())
                                    // ->enum(Habitation::class) // TODO: enable after creating EnumCollection validation rule
                                    ->multiple()
                                    ->searchable(),

                                Select::make('family')
                                    ->label(__('field.family'))
                                    ->placeholder(__('placeholder.select_many'))
                                    ->options(Family::options())
                                    // ->enum(Family::class) // TODO: enable after creating EnumCollection validation rule
                                    ->multiple()
                                    ->searchable(),

                                Select::make('education')
                                    ->label(__('field.education'))
                                    ->placeholder(__('placeholder.select_one'))
                                    ->options(Education::options())
                                    ->enum(Education::class)
                                    ->searchable(),

                                Select::make('domestic_violence')
                                    ->label(__('field.domestic_violence'))
                                    ->placeholder(__('placeholder.select_many'))
                                    ->options(DomesticViolence::options())
                                    // ->enum(DomesticViolence::class) // TODO: enable after creating EnumCollection validation rule
                                    ->multiple()
                                    ->searchable(),
                            ]),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [];
    }
}
