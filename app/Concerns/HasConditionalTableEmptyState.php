<?php

declare(strict_types=1);

namespace App\Concerns;

use Filament\Tables\Concerns\HasEmptyState;

trait HasConditionalTableEmptyState
{
    use HasEmptyState;

    public function hasAlteredTableQuery(): bool
    {
        return $this->getTableSearchQuery() || filled(request()->query('tableFilters'));
    }
}
