<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Catagraphy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToCatagraphy
{
    public function initializeBelongsToCatagraphy(): void
    {
        $this->fillable[] = 'catagraphy_id';
    }

    public function catagraphy(): BelongsTo
    {
        return $this->belongsTo(Catagraphy::class);
    }
}
