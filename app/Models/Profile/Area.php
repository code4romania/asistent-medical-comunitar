<?php

declare(strict_types=1);

namespace App\Models\Profile;

use App\Concerns\HasLocation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    use HasLocation;

    protected $table = 'profile_areas';
}
