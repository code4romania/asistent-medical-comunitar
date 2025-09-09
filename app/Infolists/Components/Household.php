<?php

declare(strict_types=1);

namespace App\Infolists\Components;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;

class Household extends Component
{
    protected string $view = 'filament-schemas::components.grid';

    final public static function make(): static
    {
        $static = app(static::class);
        $static->configure();

        return $static;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->schema([
            Subsection::make()
                ->icon('heroicon-o-user-group')
                ->columns()
                ->schema([
                    TextEntry::make('household.name')
                        ->label(__('field.household')),

                    TextEntry::make('family.name')
                        ->label(__('field.family')),
                ]),
        ]);
    }
}
