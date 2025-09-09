<?php

declare(strict_types=1);

namespace App\Forms\Components;

use Filament\Forms\Components\Concerns\HasHelperText;
use Filament\Forms\Components\Concerns\HasHint;
use Filament\Forms\Components\Concerns\HasName;
use Filament\Schemas\Components\Component;

class ServiceList extends Component
{
    use HasHelperText;
    use HasHint;
    // use HasName;

    protected string $view = 'forms.components.service-list';

    final public function __construct(string $name)
    {
        $this->name($name);
        $this->statePath($name);
    }

    public static function make(string $name): static
    {
        $static = app(static::class, ['name' => $name]);
        $static->configure();

        return $static;
    }
}
