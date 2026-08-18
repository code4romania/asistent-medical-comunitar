<?php

declare(strict_types=1);

namespace App\Filament\Schemas\Components;

use App\Enums\Intervention\EditRestriction;
use App\Models\Intervention;
use Filament\Schemas\Components\Callout;

class InterventionCallout extends Callout
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->warning();

        $this->columnSpanFull();

        $this->visible(fn (Intervention $record): bool => filled(EditRestriction::resolve($record)));

        $this->heading(fn (Intervention $record): ?string => EditRestriction::resolve($record)?->getHeading($record));

        $this->description(fn (Intervention $record): ?string => EditRestriction::resolve($record)?->getMessage($record));
    }
}
