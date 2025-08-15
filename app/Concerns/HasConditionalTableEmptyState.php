<?php

declare(strict_types=1);

namespace App\Concerns;

use Filament\Tables\Concerns\HasEmptyState;

/**
 * @deprecated Override the `table()` method to configure the table.
 */
trait HasConditionalTableEmptyState
{
    use HasEmptyState;

    /**
     * @deprecated Override the `table()` method to configure the table.
     */
    public function hasAlteredTableQuery(): bool
    {
        return $this->getTableSearchQuery() || filled(request()->query('tableFilters'));
    }
}
