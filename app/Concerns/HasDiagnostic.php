<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\ICD10AM\ICD10AMDiagnostic;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasDiagnostic
{
    public function initializeHasDiagnostic(): void
    {
        $this->fillable[] = 'diagnostic_id';
    }

    public function diagnostic(): BelongsTo
    {
        return $this->belongsTo(ICD10AMDiagnostic::class, 'diagnostic_id');
    }
}
