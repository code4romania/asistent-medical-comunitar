<?php

declare(strict_types=1);

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceCategory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'category_id');
    }
}
