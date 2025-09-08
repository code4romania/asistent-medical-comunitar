<?php

declare(strict_types=1);

namespace App\Filament\Resources\Helps;

use App\Filament\Resources\Helps\Pages\ViewHelp;
use App\Filament\Resources\HelpResource\Pages;
use Filament\Resources\Resource;

class HelpResource extends Resource
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-m-question-mark-circle';

    protected static ?int $navigationSort = 9;

    public static function getPluralModelLabel(): string
    {
        return 'Manual';
    }

    public static function getPages(): array
    {
        return [
            'index' => ViewHelp::route('/'),
        ];
    }
}
