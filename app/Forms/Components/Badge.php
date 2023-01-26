<?php

declare(strict_types=1);

namespace App\Forms\Components;

use Filament\Forms\Components\Placeholder;
use Filament\Support\Actions\Concerns\HasColor;
use Filament\Support\Actions\Concerns\HasSize;

class Badge extends Placeholder
{
    use HasColor;
    use HasSize;

    protected string $view = 'forms.components.badge';
}
