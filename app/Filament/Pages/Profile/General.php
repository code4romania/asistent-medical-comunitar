<?php

declare(strict_types=1);

namespace App\Filament\Pages\Profile;

use App\Filament\Pages\Profile;
use App\Forms\Components\Subsection;
use Filament\Forms\Components;
use Filament\Forms\Components\Grid;

class General extends Profile
{
    protected function getFormSchema(): array
    {
        return [
            Subsection::make()
                ->icon('heroicon-o-user')
                ->schema([
                    Grid::make([
                        'default' => 1,
                        'sm' => 4,
                        'xl' => 6,
                        '2xl' => 8,
                    ])
                        ->schema([
                            Components\TextInput::make('last_name')
                                ->label(__('user.profile.general_page.last_name'))
                                ->columnSpan([
                                    'sm' => 2,
                                    'xl' => 3,
                                    '2xl' => 4,
                                ]),
                            Components\TextInput::make('first_name')
                                ->label(__('user.profile.general_page.first_name'))
                                ->columnSpan([
                                    'sm' => 2,
                                    'xl' => 3,
                                    '2xl' => 4,
                                ]),
                            Components\DatePicker::make('date_of_birth')
                                ->label(__('user.profile.general_page.date_of_birth'))
                                ->columnSpan([
                                    'sm' => 2,
                                    'xl' => 3,
                                    '2xl' => 4,
                                ]),
                            Components\Select::make('sex')
                                ->label(__('user.profile.general_page.gender'))
                                ->columnSpan([
                                    'sm' => 2,
                                    'xl' => 3,
                                    '2xl' => 4,
                                ])->options([
                                    'f' => __('user.profile.general_page.feminine'),
                                    'm' => __('user.profile.general_page.masculine'),
                                    'o' => __('user.profile.general_page.other')
                                ]),
                            Components\TextInput::make('personal_id')
                                ->label(__('user.profile.general_page.personal_id'))
                                ->columnSpan([
                                    'sm' => 2,
                                    'xl' => 3,
                                    '2xl' => 4,
                                ]),
                        ]),
                ]),
            Subsection::make()
                ->icon('heroicon-o-map')
                ->schema([
                    Grid::make([
                        'default' => 1,
                        'sm' => 4,
                        'xl' => 6,
                        '2xl' => 8,
                    ])
                        ->schema([
                            Components\Select::make('country')
                                ->label(__('user.profile.general_page.county'))
                                ->columnSpan([
                                    'sm' => 2,
                                    'xl' => 3,
                                    '2xl' => 4,
                                ]),
                            Components\Select::make('city')
                                ->label(__('user.profile.general_page.city'))
                                ->columnSpan([
                                    'sm' => 2,
                                    'xl' => 3,
                                    '2xl' => 4,
                                ]),
                            Components\TextInput::make('email')
                                ->label(__('user.profile.general_page.email'))
                                ->columnSpan([
                                    'sm' => 2,
                                    'xl' => 3,
                                    '2xl' => 4,
                                ]),
                            Components\TextInput::make('phone')
                                ->label(__('user.profile.general_page.phone'))
                                ->columnSpan([
                                    'sm' => 2,
                                    'xl' => 3,
                                    '2xl' => 4,
                                ]),
                        ]),
                ]),
            Subsection::make()
                ->icon('heroicon-o-document')
                ->schema([
                    Grid::make([
                        'default' => 1,
                        'sm' => 4,
                        'xl' => 6,
                        '2xl' => 8,
                    ])
                        ->schema([
                            Components\TextInput::make('accreditation_id')
                                ->label(__('user.profile.general_page.accreditation_id'))
                                ->columnSpan([
                                    'sm' => 2,
                                    'xl' => 3,
                                    '2xl' => 4,
                                ]),
                            Components\DatePicker::make('accreditation_date')
                                ->label(__('user.profile.general_page.accreditation_date'))
                                ->columnSpan([
                                    'sm' => 2,
                                    'xl' => 3,
                                    '2xl' => 4,
                                ]),
                            Components\FileUpload::make('accreditation_file')
                                ->label(__('user.profile.general_page.accreditation_file'))
                                ->columnSpan([
                                    'sm' => 2,
                                    'xl' => 3,
                                    '2xl' => 4,
                                ]),
                        ]),
                ]),
        ];

    }
}
