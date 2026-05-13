<?php

declare(strict_types=1);

namespace App\Filament\Tables\Columns;

use Filament\Support\Enums\Alignment;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Number;

class ReportTableColumn extends TextColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->wrap();

        $this->alignment(function (self $column, mixed $state): Alignment {
            if (
                $column->getName() === 'id' ||
                is_numeric($state)
            ) {
                return Alignment::End;
            }

            return Alignment::Start;
        });

        $this->formatStateUsing(function (mixed $state): mixed {
            if (! \is_float($state)) {
                return $state;
            }

            return Number::format($state, 1);
        });
    }
}
