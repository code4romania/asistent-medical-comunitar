<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Schemas;

use Filament\Schemas\Components\Group;
use App\Enums\Beneficiary\IDType;
use App\Infolists\Components\Household;
use App\Infolists\Components\Location;
use App\Infolists\Components\Subsection;
use App\Models\Beneficiary;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Support\HtmlString;

class RegularBeneficiaryInfolist
{
    public static function getSchema(): array
    {
        return [
            Subsection::make()
                ->icon('heroicon-o-user')
                ->columns()
                ->schema([
                    TextEntry::make('first_name')
                        ->label(__('field.first_name')),

                    TextEntry::make('last_name')
                        ->label(__('field.last_name')),

                    TextEntry::make('cnp')
                        ->label(__('field.cnp'))
                        ->formatStateUsing(function (Beneficiary $record) {
                            if ($record->does_not_provide_cnp) {
                                return __('field.does_not_provide_cnp');
                            }

                            if ($record->does_not_have_cnp) {
                                return __('field.does_not_have_cnp');
                            }

                            return new HtmlString('&mdash;');
                        }),

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
                        ->label(__('field.date_of_birth')),

                    TextEntry::make('ethnicity')
                        ->label(__('field.ethnicity')),

                    TextEntry::make('work_status')
                        ->label(__('field.work_status')),
                ]),

            Household::make(),

            Subsection::make()
                ->icon('heroicon-o-map-pin')
                ->columns()
                ->schema([
                    Location::make(),

                    TextEntry::make('address')
                        ->label(__('field.address')),

                    TextEntry::make('phone')
                        ->label(__('field.phone')),
                ]),

            Subsection::make()
                ->icon('heroicon-o-chat-bubble-bottom-center-text')
                ->schema([
                    TextEntry::make('notes')
                        ->label(__('field.beneficiary_notes'))
                        ->html()
                        ->extraAttributes(['class' => 'prose max-w-none']),
                ]),
        ];
    }
}
