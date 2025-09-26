<?php

declare(strict_types=1);

namespace App\Filament\Schemas\Components;

use Filament\Schemas\Components\Section;
use Filament\Support\Enums\Width;

class Subsection extends Section
{
    protected string $view = 'filament.schemas.components.subsection';

    protected function setUp(): void
    {
        parent::setUp();

        $this->maxWidth(Width::FiveExtraLarge);
    }
}
