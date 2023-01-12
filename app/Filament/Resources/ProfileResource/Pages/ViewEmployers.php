<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Concerns\ResolvesCurrentUserProfile;
use App\Filament\Resources\ProfileResource;
use App\Forms\Components\Subsection;
use App\Models\ProfileEmployer;
use Filament\Forms\Components;
use Filament\Pages\Actions;
use Filament\Resources\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewEmployers extends ViewRecord
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
                    ->relationship('employers')
                    ->schema([
                        Subsection::make()
                            ->icon('heroicon-o-academic-cap')
                            ->schema([
                                Components\Grid::make([
                                    'default' => 1,
                                    'sm' => 4,
                                    'xl' => 6,
                                    '2xl' => 8,
                                ])
                                    ->schema([
                                        Components\Placeholder::make('name')
                                            ->label(__('user.profile.employers_page.name'))
                                            ->content(fn (ProfileEmployer $record) => $record->name)
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                        Components\Placeholder::make('type')
                                            ->label(__('user.profile.employers_page.type'))
                                            ->content(fn (ProfileEmployer $record) => __('user.profile.employers_page.' . $record->type))
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                        Components\Placeholder::make('project_name')
                                            ->label(__('user.profile.employers_page.duration'))
                                            ->content(fn (ProfileEmployer $record) => $record->project_name)
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ])->hidden(fn (ProfileEmployer $record) => empty($record->project_name)),
                                        Components\Placeholder::make('country_id')
                                            ->label(__('user.profile.employers_page.county'))
                                            ->content(fn (ProfileEmployer $record) => $record->county->name)
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                        Components\Placeholder::make('city_id')
                                            ->label(__('user.profile.employers_page.city'))
                                            ->content(fn (ProfileEmployer $record) => $record->city->name)
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                        Components\Placeholder::make('start_date')
                                            ->label(__('user.profile.employers_page.start_year'))
                                            ->content(fn (ProfileEmployer $record) => $record->start_date)
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                        Components\Placeholder::make('end_date')
                                            ->label(__('user.profile.employers_page.end_year'))
                                            ->content(fn (ProfileEmployer $record) => $record->end_date)
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
                    ->createItemButtonLabel(__('user.profile.employers_page.add_btn'))
                    ->disableItemMovement(),
            ])
            ->columns(1);
    }
}
