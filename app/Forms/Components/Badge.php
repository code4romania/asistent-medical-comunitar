<?php

declare(strict_types=1);

namespace App\Forms\Components;

use App\Concerns\Forms\HasColor;
use App\Concerns\Forms\HasSize;
use Filament\Forms\Components\Placeholder;

class Badge extends Placeholder
{
    use HasColor;
    use HasSize;

    protected string $view = 'forms.components.badge';
}
