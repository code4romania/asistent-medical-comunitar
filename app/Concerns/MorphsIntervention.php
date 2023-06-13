<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Intervention;

trait MorphsIntervention
{
    public function intervention()
    {
        return $this->morphOne(Intervention::class, 'interventionable');
    }
}
