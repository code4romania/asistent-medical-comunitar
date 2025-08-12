<?php

namespace App\Infolists\Components;

use Filament\Infolists\Components\Component;

class Testl extends Component
{
    protected string $view = 'infolists.components.testl';

    public static function make(): static
    {
        return app(static::class);
    }
}
