<?php

declare(strict_types=1);

namespace App\Filament\Pages\Profile;

use App\Filament\Pages\Profile;
use Filament\Forms\Components;

class General extends Profile
{
    protected function getFormSchema(): array
    {
        return [
            \App\Forms\Components\Subsection::make()
                ->icon('heroicon-o-collection')
                ->schema([
                    Components\TextInput::make('test 1.1'),
                    Components\TextInput::make('test 1.2'),
                    Components\TextInput::make('test 1.3'),
                    Components\TextInput::make('test 1.4'),
                ]),
        ];
    }
}
