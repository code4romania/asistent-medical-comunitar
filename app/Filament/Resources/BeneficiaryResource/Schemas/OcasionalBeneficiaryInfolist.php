<?php

declare(strict_types=1);

namespace App\Filament\Resources\AppointmentResource\Schemas;

use App\Infolists\Components\Household;
use App\Infolists\Components\Location;
use App\Infolists\Components\Subsection;
use App\Models\Beneficiary;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Support\HtmlString;

class OcasionalBeneficiaryInfolist
{
    public static function getSchema(): array
    {
        return [
            Subsection::make()
                ->icon('heroicon-o-user')
                ->columns(2)
                ->schema([
                    TextEntry::make('unknown_identity') // don't set this to 'has_unknown_identity'
                        ->default(__('field.has_unknown_identity'))
                        ->visible(fn (Beneficiary $record) => $record->has_unknown_identity)
                        ->disableLabel(),

                    Grid::make()
                        ->hidden(fn (Beneficiary $record) => $record->has_unknown_identity)
                        ->schema([
                            TextEntry::make('first_name')
                                ->label(__('field.first_name')),

                            TextEntry::make('last_name')
                                ->label(__('field.last_name')),

                            TextEntry::make('gender')
                                ->label(__('field.gender')),

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
                        ]),

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
