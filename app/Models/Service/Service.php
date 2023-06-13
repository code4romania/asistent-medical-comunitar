<?php

declare(strict_types=1);

namespace App\Models\Service;

use App\Concerns\ModelAsOptions;
use App\Contracts\Stringable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model implements Stringable
{
    use ModelAsOptions;

    public $timestamps = false;

    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function toString(): string
    {
        return $this->name;
    }
}
