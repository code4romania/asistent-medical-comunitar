<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Forms\Components\Card;
use App\Filament\Forms\Components\Subsection;
use App\Filament\Forms\Components\YearPicker;
use App\Models\Catagraphy;
use App\Models\Vulnerability\Vulnerability;
use App\Models\Vulnerability\VulnerabilityCategory;
use App\Rules\MultipleIn;
use Closure;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CatagraphyResource extends Resource
{
    protected static ?string $model = Catagraphy::class;

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        $vulnerabilities = Vulnerability::allAsOptions();
        $categories = VulnerabilityCategory::cachedList();

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
                                    ->disabled()
                                    ->searchable()
                                    ->preload(),
                            ]),

                        Subsection::make()
                            ->title(__('catagraphy.vulnerability.socioeconomic'))
                            ->icon('heroicon-o-presentation-chart-bar')
                            ->columns(2)
                            ->schema([
                                Select::make('cat_id')
                                    ->label($categories->get('ID'))
                                    ->placeholder(__('placeholder.select_one'))
                                    ->options($vulnerabilities->get('ID'))
                                    ->in($vulnerabilities->get('ID')->keys())
                                    ->searchable(),

                                Select::make('cat_age')
                                    ->label($categories->get('AGE'))
                                    ->placeholder(__('placeholder.select_one'))
                                    ->options($vulnerabilities->get('AGE'))
                                    ->in($vulnerabilities->get('AGE')->keys())
                                    ->searchable(),

                                Select::make('cat_inc')
                                    ->label($categories->get('INC'))
                                    ->placeholder(__('placeholder.select_one'))
                                    ->options($vulnerabilities->get('INC'))
                                    ->in($vulnerabilities->get('INC')->keys())
                                    ->searchable(),

                                Select::make('cat_pov')
                                    ->label($categories->get('POV'))
                                    ->placeholder(__('placeholder.select_one'))
                                    ->options($vulnerabilities->get('POV'))
                                    ->in($vulnerabilities->get('POV')->keys())
                                    ->searchable(),

                                Select::make('cat_liv')
                                    ->label($categories->get('LIV'))
                                    ->placeholder(__('placeholder.select_many'))
                                    ->options($vulnerabilities->get('LIV'))
                                    ->rule(new MultipleIn($vulnerabilities->get('LIV')->keys()))
                                    ->multiple()
                                    ->searchable(),

                                Select::make('cat_fam')
                                    ->label($categories->get('FAM'))
                                    ->placeholder(__('placeholder.select_many'))
                                    ->options($vulnerabilities->get('FAM'))
                                    ->rule(new MultipleIn($vulnerabilities->get('FAM')->keys()))
                                    ->multiple()
                                    ->searchable(),

                                Select::make('cat_edu')
                                    ->label($categories->get('EDU'))
                                    ->placeholder(__('placeholder.select_one'))
                                    ->options($vulnerabilities->get('EDU'))
                                    ->in($vulnerabilities->get('EDU')->keys())
                                    ->searchable(),

                                Select::make('cat_vif')
                                    ->label($categories->get('VIF'))
                                    ->placeholder(__('placeholder.select_many'))
                                    ->options($vulnerabilities->get('VIF'))
                                    ->rule(new MultipleIn($vulnerabilities->get('VIF')->keys()))
                                    ->multiple()
                                    ->searchable(),
                            ]),

                        Subsection::make()
                            ->title(__('catagraphy.vulnerability.health'))
                            ->icon('heroicon-o-heart')
                            ->columns(2)
                            ->schema([

                                Select::make('cat_as')
                                    ->label($categories->get('AS'))
                                    ->placeholder(__('placeholder.select_one'))
                                    ->options($vulnerabilities->get('AS'))
                                    ->in($vulnerabilities->get('AS')->keys())
                                    ->searchable(),

                                Select::make('cat_mf')
                                    ->label($categories->get('MF'))
                                    ->placeholder(__('placeholder.select_one'))
                                    ->options($vulnerabilities->get('MF'))
                                    ->in($vulnerabilities->get('MF')->keys())
                                    ->searchable(),

                                Grid::make()
                                    ->columnSpanFull()
                                    ->schema([
                                        Select::make('cat_diz')
                                            ->label($categories->get('DIZ'))
                                            ->placeholder(__('placeholder.select_one'))
                                            ->options($vulnerabilities->get('DIZ'))
                                            ->in($vulnerabilities->get('DIZ')->keys())
                                            ->reactive()
                                            ->searchable(),
                                    ]),

                                Card::make()
                                    ->header(__('field.section_details', ['section' => $categories->get('DIZ')]))
                                    ->columnSpanFull()
                                    ->pointer()
                                    ->visible(fn (Closure $get) => Vulnerability::isValidCode($get('cat_diz')))
                                    ->schema([
                                        Repeater::make('disabilities')
                                            ->relationship()
                                            ->createItemButtonLabel(__('catagraphy.action.add_disability'))
                                            ->disableItemMovement()
                                            ->disableLabel()
                                            ->columns()
                                            ->minItems(1)
                                            ->schema([
                                                Select::make('type')
                                                    ->label($categories->get('DIZ_TIP'))
                                                    ->placeholder(__('placeholder.select_one'))
                                                    ->options($vulnerabilities->get('DIZ_TIP'))
                                                    ->in($vulnerabilities->get('DIZ_TIP')->keys())
                                                    ->searchable(),

                                                Select::make('degree')
                                                    ->label($categories->get('DIZ_GR'))
                                                    ->placeholder(__('placeholder.select_one'))
                                                    ->options($vulnerabilities->get('DIZ_GR'))
                                                    ->in($vulnerabilities->get('DIZ_GR')->keys())
                                                    ->searchable(),

                                                Select::make('diagnostic')
                                                    ->label(__('field.cat_diz_dx'))
                                                    ->disabled(),

                                                Select::make('diagnostic_code')
                                                    ->label(__('field.cat_diz_cdx'))
                                                    ->disabled(),

                                                Checkbox::make('receives_pension')
                                                    ->label(__('field.cat_diz_iph'))
                                                    ->columnSpanFull(),

                                                YearPicker::make('start_year')
                                                    ->label(__('field.cat_diz_deb')),

                                                TextInput::make('notes')
                                                    ->label(__('field.cat_diz_am'))
                                                    ->nullable()
                                                    ->maxLength(100),
                                            ]),
                                    ]),

                                Select::make('cat_cr')
                                    ->label($categories->get('CR'))
                                    ->placeholder(__('placeholder.select_many'))
                                    ->options($vulnerabilities->get('CR'))
                                    ->rule(new MultipleIn($vulnerabilities->get('CR')->keys()))
                                    ->multiple()
                                    ->searchable(),

                                Select::make('cat_ns')
                                    ->label($categories->get('NS'))
                                    ->placeholder(__('placeholder.select_many'))
                                    ->options($vulnerabilities->get('NS'))
                                    ->rule(new MultipleIn($vulnerabilities->get('NS')->keys()))
                                    ->multiple()
                                    ->searchable(),

                                Select::make('cat_ssa')
                                    ->label($categories->get('SSA'))
                                    ->placeholder(__('placeholder.select_many'))
                                    ->options($vulnerabilities->get('SSA'))
                                    ->rule(new MultipleIn($vulnerabilities->get('SSA')->keys()))
                                    ->multiple()
                                    ->searchable(),

                                Select::make('cat_ss')
                                    ->label($categories->get('SS'))
                                    ->placeholder(__('placeholder.select_many'))
                                    ->options($vulnerabilities->get('SS'))
                                    ->rule(new MultipleIn($vulnerabilities->get('SS')->keys()))
                                    ->reactive()
                                    ->multiple()
                                    ->searchable(),

                                Card::make()
                                    ->header(__('field.section_details', ['section' => $categories->get('SS')]))
                                    ->columnSpanFull()
                                    ->pointer('right')
                                    ->visible(fn (Closure $get) => Vulnerability::isValidCode($get('cat_ss')))
                                    ->schema([
                                        Repeater::make('diseases')
                                            ->relationship()
                                            ->createItemButtonLabel(__('catagraphy.action.add_disease'))
                                            ->disableItemMovement()
                                            ->disableLabel()
                                            ->columns()
                                            ->minItems(1)
                                            ->schema([
                                                Select::make('type')
                                                    ->label($categories->get('SS'))
                                                    ->placeholder(__('placeholder.select_one'))
                                                    ->options($vulnerabilities->get('SS'))
                                                    ->in($vulnerabilities->get('SS')->keys())
                                                    ->searchable(),

                                                Select::make('category')
                                                    ->label($categories->get('SS_B'))
                                                    ->placeholder(__('placeholder.select_one'))
                                                    ->options($vulnerabilities->get('SS_B'))
                                                    ->in($vulnerabilities->get('SS_B')->keys())
                                                    ->searchable(),

                                                Select::make('diagnostic')
                                                    ->label(__('field.cat_diz_dx'))
                                                    ->disabled(),

                                                Select::make('diagnostic_code')
                                                    ->label(__('field.cat_diz_cdx'))
                                                    ->disabled(),

                                                YearPicker::make('start_year')
                                                    ->label(__('field.cat_diz_deb')),

                                                TextInput::make('notes')
                                                    ->label(__('field.cat_diz_am'))
                                                    ->nullable()
                                                    ->maxLength(100),
                                            ]),
                                    ]),
                            ]),

                        Subsection::make()
                            ->title(__('catagraphy.vulnerability.reproductive_health'))
                            ->icon('heroicon-o-heart')
                            ->columns(2)
                            ->schema([
                                Select::make('cat_rep')
                                    ->label($categories->get('REP'))
                                    ->placeholder(__('placeholder.select_one'))
                                    ->options($vulnerabilities->get('REP'))
                                    ->in($vulnerabilities->get('REP')->keys())
                                    ->reactive()
                                    ->searchable(),

                                Card::make()
                                    ->header(__('field.section_details', ['section' => $categories->get('PREG')]))
                                    ->columns()
                                    ->columnSpanFull()
                                    ->pointer()
                                    ->visible(fn (Closure $get) => Vulnerability::isPregnancy($get('cat_rep')))
                                    ->schema([
                                        Select::make('cat_preg')
                                            ->label($categories->get('PREG'))
                                            ->placeholder(__('placeholder.select_many'))
                                            ->options($vulnerabilities->get('PREG'))
                                            ->rule(new MultipleIn($vulnerabilities->get('PREG')->keys()))
                                            ->multiple()
                                            ->searchable(),
                                    ]),
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
