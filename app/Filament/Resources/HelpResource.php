<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\HelpResource\Pages;
use Filament\Resources\Resource;

class HelpResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-m-question-mark-circle';

    protected static ?int $navigationSort = 9;

    public static function getPluralModelLabel(): string
    {
        return 'Manual';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ViewHelp::route('/'),
        ];
    }
}
