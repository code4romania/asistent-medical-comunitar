<?php

declare(strict_types=1);

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Component;

class ReportTable extends Component
{
    protected string $view = 'components.forms.report-table';

    public static function make(): static
    {
        $static = app(static::class);
        $static->configure();

        return $static;
    }
}
