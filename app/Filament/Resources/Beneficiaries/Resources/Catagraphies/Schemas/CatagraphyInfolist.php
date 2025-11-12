<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Catagraphies\Schemas;

use App\Filament\Infolists\Components\VulnerabilityChips;
use App\Filament\Schemas\Components\Subsection;
use App\Models\Vulnerability\Vulnerability;
use App\Models\Vulnerability\VulnerabilityCategory;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class CatagraphyInfolist
{
    public static function configure(Schema $schema): Schema
    {
        $categories = VulnerabilityCategory::cachedList();

        return $schema
            ->columns(1)
            ->components([
                Section::make()
                    ->components([
                        Subsection::make()
                            ->heading(__('catagraphy.section.general'))
                            ->icon(Heroicon::OutlinedInformationCircle)
                            ->components([
                                TextEntry::make('evaluation_date')
                                    ->label(__('field.evaluation_date'))
                                    ->date(),

                                VulnerabilityChips::make('cat_soc')
                                    ->label($categories->get('SOC')),
                            ]),

                        Subsection::make()
                            ->heading(__('catagraphy.vulnerability.socioeconomic'))
                            ->icon(Heroicon::OutlinedPresentationChartBar)
                            ->columns()
                            ->components([
                                VulnerabilityChips::make('cat_id')
                                    ->label($categories->get('ID')),

                                VulnerabilityChips::make('cat_age')
                                    ->label($categories->get('AGE')),

                                VulnerabilityChips::make('cat_inc')
                                    ->label($categories->get('INC')),

                                VulnerabilityChips::make('cat_pov')
                                    ->label($categories->get('POV')),

                                VulnerabilityChips::make('cat_liv')
                                    ->label($categories->get('LIV')),

                                VulnerabilityChips::make('cat_fam')
                                    ->label($categories->get('FAM')),

                                VulnerabilityChips::make('cat_edu')
                                    ->label($categories->get('EDU')),

                                VulnerabilityChips::make('cat_vif')
                                    ->label($categories->get('VIF')),
                            ]),

                        Subsection::make()
                            ->heading(__('catagraphy.vulnerability.health'))
                            ->icon(Heroicon::OutlinedHeart)
                            ->columns()
                            ->components([
                                VulnerabilityChips::make('cat_as')
                                    ->label($categories->get('AS')),

                                VulnerabilityChips::make('cat_mf')
                                    ->label($categories->get('MF')),

                                VulnerabilityChips::make('cat_diz')
                                    ->label($categories->get('DIZ'))
                                    ->columnSpanFull(),

                                VulnerabilityChips::make('cat_cr')
                                    ->label($categories->get('CR')),

                                VulnerabilityChips::make('cat_ns')
                                    ->label($categories->get('NS')),

                                VulnerabilityChips::make('cat_ssa')
                                    ->label($categories->get('SSA')),

                                VulnerabilityChips::make('cat_ss')
                                    ->label($categories->get('SS')),
                            ]),

                        Subsection::make()
                            ->heading(__('catagraphy.vulnerability.reproductive_health'))
                            ->icon(Heroicon::OutlinedHeart)
                            ->columns()
                            ->components([
                                VulnerabilityChips::make('cat_rep')
                                    ->label($categories->get('REP')),

                                VulnerabilityChips::make('cat_preg')
                                    ->label($categories->get('PREG')),
                                // ->visible(fn (Get $get) => dd($get('cat_rep')) && Vulnerability::isPregnancy($get('cat_rep'))),
                            ]),

                        Subsection::make()
                            ->heading(__('catagraphy.section.suspicions'))
                            ->icon(Heroicon::OutlinedQuestionMarkCircle)
                            ->components([
                                VulnerabilityChips::make('suspicions')
                                    ->label($categories->get('SUS_CS')),
                            ]),

                        Subsection::make()
                            ->heading(__('catagraphy.section.notes'))
                            ->icon(Heroicon::OutlinedChatBubbleBottomCenterText)
                            ->components([
                                TextEntry::make('notes')
                                    ->hiddenLabel()
                                    ->extraAttributes(['class' => 'prose max-w-none'])
                                    ->html(),
                            ]),
                    ]),
            ]);
    }
}
