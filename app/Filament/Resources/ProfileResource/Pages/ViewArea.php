<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Concerns\ResolvesCurrentUserProfile;
use App\Filament\Resources\ProfileResource;
use App\Forms\Components\Subsection;
use App\Models\Area;
use Filament\Forms\Components;
use Filament\Pages\Actions;
use Filament\Resources\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewArea extends ViewRecord
{
    use ResolvesCurrentUserProfile;

    protected static string $resource = ProfileResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    protected function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\Repeater::make('studies_repeater')
                    ->relationship('areas')
                    ->schema([
                        Subsection::make()
                            ->icon('heroicon-o-map')
                            ->schema([
                                Components\Grid::make([
                                    'default' => 1,
                                    'sm' => 4,
                                    'xl' => 6,
                                    '2xl' => 8,
                                ])
                                    ->schema([

                                        Components\Placeholder::make('country_id')
                                            ->label(__('user.profile.area_page.county'))
                                            ->content(fn (Area $record) => $record->county->name)
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                        Components\Placeholder::make('city_id')
                                            ->label(__('user.profile.area_page.city'))
                                            ->content(fn (Area $record) => $record->city->name)
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                    ]),
                            ]),
                    ])
                    ->label(__('user.profile.employers'))
                    ->defaultItems(1)
                    ->createItemButtonLabel(__('user.profile.area_page.add_btn'))
                    ->disableItemMovement(),
            ])
            ->columns(1);
    }
    protected function getRelationManagers(): array
    {
        return [
        ];
    }
}
