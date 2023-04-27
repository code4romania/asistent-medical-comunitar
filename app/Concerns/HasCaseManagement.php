<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Intervention\CaseManagement;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasCaseManagement
{
    public function cases(): HasMany
    {
        return $this->hasMany(CaseManagement::class);
    }
}
