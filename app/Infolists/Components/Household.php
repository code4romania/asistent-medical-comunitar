<?php

declare(strict_types=1);

namespace App\Infolists\Components;

use Filament\Infolists\Components\Component;
use Filament\Infolists\Components\TextEntry;

class Household extends Component
{
    protected string $view = 'filament-infolists::components.group';

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
