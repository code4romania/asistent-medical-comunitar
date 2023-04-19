<?php

declare(strict_types=1);

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    public $timestamps = false;

    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class);
    }
}
