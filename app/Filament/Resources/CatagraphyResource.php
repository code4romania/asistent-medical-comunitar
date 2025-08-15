<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Forms\Components\ICD10AMDiagnosticSelect;
use App\Forms\Components\OrphaDiagnosticSelect;
use App\Forms\Components\Repeater;
use App\Forms\Components\Subsection;
use App\Forms\Components\YearPicker;
use App\Models\Catagraphy;
use App\Models\Vulnerability\Vulnerability;
use App\Models\Vulnerability\VulnerabilityCategory;
use App\Rules\MultipleIn;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Livewire\Component;

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
                Section::make()
                    ->schema([
                        Subsection::make()
                            ->title(__('catagraphy.section.general'))
                            ->icon('heroicon-o-information-circle')
                            ->columns(2)
                            ->schema([
                                DatePicker::make('evaluation_date')
                                    ->label(__('field.evaluation_date'))
                                    ->required(),

                                Checkbox::make('is_social_case')
                                    ->label($categories->get('SOC'))
                                    ->columnSpanFull(),
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

                                Select::make('has_disabilities')
                                    ->label($categories->get('DIZ'))
                                    ->columnSpanFull()
                                    ->boolean(
                                        trueLabel: __('field.cat_diz_yes'),
                                        falseLabel: __('field.cat_diz_no'),
                                        placeholder: __('placeholder.select_one'),
                                    )
                                    ->formatStateUsing(fn (?bool $state) => ! \is_null($state) ? (int) $state : $state)
                                    ->live()
                                    ->afterStateUpdated(function ($state, \Filament\Forms\Get $get, Component $livewire) {
                                        $state = \boolval($state);

                                        if (! $state) {
                                            return;
                                        }

                                        if (collect($get('disabilities'))->isNotEmpty()) {
                                            return;
                                        }

                                        $livewire->dispatchFormEvent('repeater::createItem', 'data.disabilities');
                                    }),

                                Section::make()
                                    ->header(__('field.section_details', ['section' => $categories->get('DIZ')]))
                                    ->columnSpanFull()
                                    ->pointer()
                                    ->visible(fn (\Filament\Forms\Get $get) => \boolval($get('has_disabilities')))
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
                                                    ->searchable()
                                                    ->required(),

                                                Select::make('degree')
                                                    ->label($categories->get('DIZ_GR'))
                                                    ->placeholder(__('placeholder.select_one'))
                                                    ->options($vulnerabilities->get('DIZ_GR'))
                                                    ->in($vulnerabilities->get('DIZ_GR')->keys())
                                                    ->searchable(),

                                                ICD10AMDiagnosticSelect::make('diagnostic')
                                                    ->label(__('field.cat_diz_dx')),

                                                Checkbox::make('has_certificate')
                                                    ->label(__('field.cat_diz_cert'))
                                                    ->columnSpanFull(),

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

                                Select::make('has_health_issues')
                                    ->label($categories->get('SS'))
                                    ->columnSpanFull()
                                    ->boolean(
                                        trueLabel: __('field.cat_ss_yes'),
                                        falseLabel: __('field.cat_ss_no'),
                                        placeholder: __('placeholder.select_one'),
                                    )
                                    ->formatStateUsing(fn (?bool $state) => ! \is_null($state) ? (int) $state : $state)
                                    ->live()
                                    ->afterStateUpdated(function ($state, \Filament\Forms\Get $get, Component $livewire) {
                                        $state = \boolval($state);

                                        if (! $state) {
                                            return;
                                        }

                                        if (collect($get('diseases'))->isNotEmpty()) {
                                            return;
                                        }

                                        $livewire->dispatchFormEvent('repeater::createItem', 'data.diseases');
                                    }),

                                Section::make()
                                    ->header(__('field.section_details', ['section' => $categories->get('SS')]))
                                    ->columnSpanFull()
                                    ->pointer('right')
                                    ->visible(fn (\Filament\Forms\Get $get) => \boolval($get('has_health_issues')))
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
                                                    ->options($vulnerabilities->get('SS')->except('VSG_99'))
                                                    ->in($vulnerabilities->get('SS')->except('VSG_99')->keys())
                                                    ->searchable()
                                                    ->required(),

                                                Select::make('category')
                                                    ->label($categories->get('SS_B'))
                                                    ->placeholder(__('placeholder.select_one'))
                                                    ->options($vulnerabilities->get('SS_B'))
                                                    ->in($vulnerabilities->get('SS_B')->keys())
                                                    ->live()
                                                    ->searchable(),

                                                ICD10AMDiagnosticSelect::make('diagnostic')
                                                    ->label(__('field.cat_diz_dx'))
                                                    ->columnSpanFull(),

                                                Select::make('rare_disease')
                                                    ->label($categories->get('SS_SL'))
                                                    ->placeholder(__('placeholder.select_one'))
                                                    ->options($vulnerabilities->get('SS_SL'))
                                                    ->in($vulnerabilities->get('SS_SL')->keys())
                                                    ->searchable()
                                                    ->visible(fn (\Filament\Forms\Get $get) => $get('category') === 'VSG_BR')
                                                    ->columnSpanFull(),

                                                OrphaDiagnosticSelect::make('orphaDiagnostic')
                                                    ->label(__('field.cat_ss_orph'))
                                                    ->visible(fn (\Filament\Forms\Get $get) => $get('category') === 'VSG_BR')
                                                    ->columnSpanFull(),

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
                                    ->live()
                                    ->searchable(),

                                Section::make()
                                    ->header(__('field.section_details', ['section' => $categories->get('PREG')]))
                                    ->columns()
                                    ->columnSpanFull()
                                    ->pointer()
                                    ->visible(fn (\Filament\Forms\Get $get) => Vulnerability::isPregnancy($get('cat_rep')))
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
                            ->title(__('catagraphy.section.suspicions'))
                            ->icon('heroicon-o-question-mark-circle')
                            ->schema([
                                Repeater::make('suspicions')
                                    ->relationship()
                                    ->createItemButtonLabel(__('catagraphy.action.add_suspicion'))
                                    ->disableItemMovement()
                                    ->disableLabel()
                                    ->columns()
                                    ->schema([
                                        TextInput::make('name')
                                            ->label(__('field.suspicion_name'))
                                            ->required(),

                                        Select::make('category')
                                            ->label(__('field.suspicion_category'))
                                            ->placeholder(__('placeholder.select_one'))
                                            ->label($categories->get('SUS_CS'))
                                            ->options($vulnerabilities->get('SUS_CS'))
                                            ->in($vulnerabilities->get('SUS_CS')->keys())
                                            ->required()
                                            ->live(),

                                        Select::make('elements')
                                            ->label(__('field.suspicion_elements'))
                                            ->placeholder(__('placeholder.select_many'))
                                            ->multiple()
                                            ->label($categories->get('SUS_BR_ES'))
                                            ->options($vulnerabilities->get('SUS_BR_ES'))
                                            ->rule(new MultipleIn($vulnerabilities->get('SUS_BR_ES')->keys()))
                                            ->visible(fn (\Filament\Forms\Get $get) => $get('category') === 'VSP_01')
                                            ->columnSpanFull(),

                                        TextInput::make('notes')
                                            ->label(__('field.suspicion_notes'))
                                            ->maxLength(100)
                                            ->nullable()
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Subsection::make()
                            ->title(__('catagraphy.section.notes'))
                            ->icon('heroicon-o-chat-bubble-bottom-center-text')
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
