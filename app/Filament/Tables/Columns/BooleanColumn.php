<?php

declare(strict_types=1);

namespace App\Filament\Tables\Columns;

use App\Concerns\HasBooleanLabels;
use Filament\Tables\Columns\TextColumn;

class BooleanColumn extends TextColumn
{
    use HasBooleanLabels;

    protected function setUp(): void
    {
        parent::setUp();

        $this->formatStateUsing(fn (mixed $state) => \boolval($state) ? $this->getTrueLabel() : $this->getFalseLabel());
    }
}
