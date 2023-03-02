<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\Catagraphy\AgeCategory;
use App\Enums\Catagraphy\DomesticViolence;
use App\Enums\Catagraphy\Education;
use App\Enums\Catagraphy\Family;
use App\Enums\Catagraphy\Habitation;
use App\Enums\Catagraphy\IDType;
use App\Enums\Catagraphy\Income;
use App\Enums\Catagraphy\Poverty;
use App\Forms\Components\Card;
use App\Forms\Components\Subsection;
use App\Models\Catagraphy;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;

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
                                DatePicker::make('evaluation_date')
                                    ->default(today()),

                                Select::make('amc_id')
                                    ->relationship('amc', 'first_name')
                                    ->searchable()
                                    ->default(auth()->id()),
                            ]),

                        Subsection::make()
                            ->icon('heroicon-o-presentation-chart-bar')
                            ->columns(2)
                            ->schema([
                                Select::make('id_type')
                                    ->options(IDType::options())
                                    ->enum(IDType::class),

                                Select::make('age_category')
                                    ->options(AgeCategory::options())
                                    ->enum(AgeCategory::class),

                                Select::make('income')
                                    ->options(Income::options())
                                    ->enum(Income::class),

                                Select::make('poverty')
                                    ->options(Poverty::options())
                                    ->enum(Poverty::class),

                                Select::make('habitation')
                                    ->multiple()
                                    ->options(Habitation::options())
                                    ->enum(Habitation::class),

                                Select::make('family')
                                    ->multiple()
                                    ->options(Family::options())
                                    ->enum(Family::class),

                                Select::make('education')
                                    ->options(Education::options())
                                    ->enum(Education::class),

                                Select::make('domestic_violence')
                                    ->multiple()
                                    ->options(DomesticViolence::options())
                                    ->enum(DomesticViolence::class),
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
