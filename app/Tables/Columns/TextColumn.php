<?php

declare(strict_types=1);

namespace App\Tables\Columns;

use Filament\Tables\Columns\TextColumn as Column;

class TextColumn extends Column
{
    public function boolean(?string $trueLabel = null, ?string $falseLabel = null): static
    {
        $trueLabel ??= __('forms::components.select.boolean.true');
        $falseLabel ??= __('forms::components.select.boolean.false');

        $this->formatStateUsing(fn ($state) => (bool) $state ? $trueLabel : $falseLabel);

        return $this;
    }
}
