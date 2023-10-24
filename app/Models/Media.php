<?php

declare(strict_types=1);

namespace App\Models;

use Spatie\MediaLibrary\MediaCollections\Models\Media as Model;

class Media extends Model
{
    public function getOriginalFileNameAttribute(): string
    {
        return $this->name . '.' . $this->extension;
    }
}
