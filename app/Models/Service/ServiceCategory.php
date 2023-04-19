<?php

declare(strict_types=1);

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];
}
