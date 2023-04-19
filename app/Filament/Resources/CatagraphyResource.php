<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\Vulnerability;
use App\Forms\Components\Card;
use App\Forms\Components\Subsection;
use App\Models\Catagraphy;
use App\Rules\EnumCollection;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
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
                            ->title(__('catagraphy.section.general'))
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
                            ->title(__('catagraphy.vulnerability.socioeconomic'))
                            ->icon('heroicon-o-presentation-chart-bar')
                            ->columns(2)
                            ->schema([
                                Select::make('cat_id')
                                    ->label(__('vulnerability.field.cat_id'))
                                    ->placeholder(__('placeholder.select_one'))
                                    ->options(Vulnerability\CatId::options())
                                    ->enum(Vulnerability\CatId::class)
                                    ->searchable(),

                                Select::make('cat_age')
                                    ->label(__('vulnerability.field.cat_age'))
                                    ->placeholder(__('placeholder.select_one'))
                                    ->options(Vulnerability\CatAge::options())
                                    ->enum(Vulnerability\CatAge::class)
                                    ->searchable(),

                                Select::make('cat_inc')
                                    ->label(__('vulnerability.field.cat_inc'))
                                    ->placeholder(__('placeholder.select_one'))
                                    ->options(Vulnerability\CatInc::options())
                                    ->enum(Vulnerability\CatInc::class)
                                    ->searchable(),

                                Select::make('cat_pov')
                                    ->label(__('vulnerability.field.cat_pov'))
                                    ->placeholder(__('placeholder.select_one'))
                                    ->options(Vulnerability\CatPov::options())
                                    ->enum(Vulnerability\CatPov::class)
                                    ->searchable(),

                                Select::make('cat_liv')
                                    ->label(__('vulnerability.field.cat_liv'))
                                    ->placeholder(__('placeholder.select_many'))
                                    ->options(Vulnerability\CatLiv::options())
                                    ->rule(new EnumCollection(Vulnerability\CatLiv::class))
                                    ->multiple()
                                    ->searchable(),

                                Select::make('cat_fam')
                                    ->label(__('vulnerability.field.cat_fam'))
                                    ->placeholder(__('placeholder.select_many'))
                                    ->options(Vulnerability\CatFam::options())
                                    ->rule(new EnumCollection(Vulnerability\CatFam::class))
                                    ->multiple()
                                    ->searchable(),

                                Select::make('cat_edu')
                                    ->label(__('vulnerability.field.cat_edu'))
                                    ->placeholder(__('placeholder.select_one'))
                                    ->options(Vulnerability\CatEdu::options())
                                    ->enum(Vulnerability\CatEdu::class)
                                    ->searchable(),

                                Select::make('cat_vif')
                                    ->label(__('vulnerability.field.cat_vif'))
                                    ->placeholder(__('placeholder.select_many'))
                                    ->options(Vulnerability\CatVif::options())
                                    ->rule(new EnumCollection(Vulnerability\CatVif::class))
                                    ->multiple()
                                    ->searchable(),
                            ]),

                        Subsection::make()
                            ->title(__('catagraphy.vulnerability.health'))
                            ->icon('heroicon-o-heart')
                            ->columns(2)
                            ->schema([

                                Select::make('cat_as')
                                    ->label(__('vulnerability.field.cat_as'))
                                    ->placeholder(__('placeholder.select_one'))
                                    ->options(Vulnerability\CatAs::options())
                                    ->enum(Vulnerability\CatAs::class)
                                    ->searchable(),

                                Select::make('cat_mf')
                                    ->label(__('vulnerability.field.cat_mf'))
                                    ->placeholder(__('placeholder.select_one'))
                                    ->options(Vulnerability\CatMf::options())
                                    ->enum(Vulnerability\CatMf::class)
                                    ->searchable(),

                                Select::make('cat_diz')
                                    ->label(__('vulnerability.field.cat_diz'))
                                    ->placeholder(__('placeholder.select_one'))
                                    ->options(Vulnerability\CatDiz::options())
                                    ->enum(Vulnerability\CatDiz::class)
                                    ->searchable(),

                                Select::make('cat_cr')
                                    ->label(__('vulnerability.field.cat_cr'))
                                    ->placeholder(__('placeholder.select_many'))
                                    ->options(Vulnerability\CatCr::options())
                                    ->rule(new EnumCollection(Vulnerability\CatCr::class))
                                    ->multiple()
                                    ->searchable(),

                                Select::make('cat_ns')
                                    ->label(__('vulnerability.field.cat_ns'))
                                    ->placeholder(__('placeholder.select_many'))
                                    ->options(Vulnerability\CatNs::options())
                                    ->rule(new EnumCollection(Vulnerability\CatNs::class))
                                    ->multiple()
                                    ->searchable(),

                                Select::make('cat_ssa')
                                    ->label(__('vulnerability.field.cat_ssa'))
                                    ->placeholder(__('placeholder.select_many'))
                                    ->options(Vulnerability\CatSsa::options())
                                    ->rule(new EnumCollection(Vulnerability\CatSsa::class))
                                    ->multiple()
                                    ->searchable(),
                            ]),

                        Subsection::make()
                            ->title(__('catagraphy.vulnerability.reproductive_health'))
                            ->icon('heroicon-o-heart')
                            ->columns(2)
                            ->schema([
                                Select::make('cat_rep')
                                    ->label(__('vulnerability.field.cat_rep'))
                                    ->placeholder(__('placeholder.select_one'))
                                    ->options(Vulnerability\CatRep::options())
                                    ->enum(Vulnerability\CatRep::class)
                                    ->searchable(),

                                Select::make('cat_preg')
                                    ->label(__('vulnerability.field.cat_preg'))
                                    ->placeholder(__('placeholder.select_many'))
                                    ->options(Vulnerability\CatPreg::options())
                                    ->rule(new EnumCollection(Vulnerability\CatPreg::class))
                                    ->multiple()
                                    ->searchable(),
                            ]),

                        Subsection::make()
                            ->title(__('catagraphy.section.notes'))
                            ->icon('heroicon-o-annotation')
                            ->schema([
                                RichEditor::make('notes')
                                    ->disableLabel()
                                    ->toolbarButtons(['bold', 'italic', 'strike', 'bulletList', 'orderedList', 'redo', 'undo'])
                                    ->nullable()
                                    ->maxLength(65535),
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
