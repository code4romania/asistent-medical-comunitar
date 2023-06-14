<?php

declare(strict_types=1);

namespace App\Forms\Components;

use App\Concerns\Forms\HasIcon;
use App\Concerns\Forms\HasTitle;
use Filament\Forms\Components\Component;

class Subsection extends Component
{
    use HasIcon;
    use HasTitle;

    protected string $view = 'components.forms.subsection';

    public static function make(): static
    {
        $static = app(static::class);
        $static->configure();

        return $static;
    }
}
