<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Schemas;

use App\Enums\Beneficiary\IDType;
use App\Enums\Beneficiary\ReasonRemoved;
use App\Enums\Beneficiary\Status;
use App\Filament\Infolists\Components\BooleanEntry;
use App\Filament\Infolists\Components\Household;
use App\Filament\Infolists\Components\Location;
use App\Filament\Schemas\Components\Subsection;
use App\Models\Beneficiary;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;

class RegularBeneficiaryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make()
                    ->heading(__('beneficiary.section.program'))
                    ->components([
                        Grid::make()
                            ->columns()
                            ->maxWidth(Width::FiveExtraLarge)
                            ->components([
                                TextEntry::make('id')
                                    ->label(__('field.beneficiary_id')),

                                TextEntry::make('type')
                                    ->label(__('field.beneficiary_type')),

                                TextEntry::make('status')
                                    ->label(__('field.current_status')),

                                TextEntry::make('reason_removed')
                                    ->label(__('field.reason_removed'))
                                    ->visible(fn (Get $get) => Status::REMOVED->is($get('status')))
                                    ->formatStateUsing(function (Beneficiary $record) {
                                        $parts = [];

                                        if ($record->reason_removed instanceof ReasonRemoved) {
                                            $parts[] = $record->reason_removed->getLabel();
                                        }

                                        if (filled($record->reason_removed_notes)) {
                                            $parts[] = "({$record->reason_removed_notes})";
                                        }

                                        return implode(' ', $parts);
                                    }),

                                TextEntry::make('nurse.full_name')
                                    ->label(__('field.allocated_nurse')),

                                BooleanEntry::make('integrated')
                                    ->label(__('field.integrated')),
                            ]),
                    ]),

                Section::make()
                    ->heading(__('beneficiary.header.id'))
                    ->headerActions([
                        EditAction::make()
                            ->icon(Heroicon::Pencil),
                    ])
                    ->components([
                        Subsection::make()
                            ->icon(Heroicon::OutlinedUser)
                            ->columns()
                            ->components([
                                TextEntry::make('first_name')
                                    ->label(__('field.first_name')),

                                TextEntry::make('last_name')
                                    ->label(__('field.last_name')),

                                TextEntry::make('cnp_with_fallback')
                                    ->label(__('field.cnp')),

                                TextEntry::make('id_type')
                                    ->label(__('field.id_type')),

                                Group::make()
                                    ->columns()
                                    ->columnSpanFull()
                                    ->hidden(fn (Beneficiary $record) => IDType::NONE->is($record->id_type))
                                    ->schema([
                                        TextEntry::make('id_serial')
                                            ->label(__('field.id_serial')),

                                        TextEntry::make('id_number')
                                            ->label(__('field.id_number')),
                                    ]),

                                TextEntry::make('gender')
                                    ->label(__('field.gender')),

                                TextEntry::make('date_of_birth')
                                    ->label(__('field.date_of_birth'))
                                    ->date(),

                                TextEntry::make('ethnicity')
                                    ->label(__('field.ethnicity')),

                                TextEntry::make('work_status')
                                    ->label(__('field.work_status')),
                            ]),

                        Household::make(),

                        Location::make(),

                        Subsection::make()
                            ->icon(Heroicon::OutlinedChatBubbleBottomCenterText)
                            ->components([
                                TextEntry::make('notes')
                                    ->label(__('field.beneficiary_notes'))
                                    ->extraAttributes(['class' => 'prose max-w-none'])
                                    ->html(),
                            ]),
                    ]),
            ]);
    }
}
