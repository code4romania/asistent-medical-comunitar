<?php

declare(strict_types=1);

namespace App\Forms\Components;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\Concerns;

class ServiceList extends Component
{
    use Concerns\HasHelperText;
    use Concerns\HasHint;
    use Concerns\HasName;

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
