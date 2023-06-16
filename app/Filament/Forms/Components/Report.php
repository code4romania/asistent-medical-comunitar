<?php

declare(strict_types=1);

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Component;

class Report extends Component
{
    protected string $view = 'components.forms.report';

    public static function make(): static
    {
        $static = app(static::class);
        $static->configure();

        return $static;
    }
}
