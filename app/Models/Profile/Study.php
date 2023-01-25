<?php

declare(strict_types=1);

namespace App\Models\Profile;

use App\Concerns\HasLocation;
use App\Enums\StudyType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Study extends Model
{
    use HasFactory;
    use HasLocation;

    protected $table = 'profile_studies';

    protected $fillable = [
        'name',
        'type',
        'institution',
        'duration',
        'start_year',
        'end_year',
    ];

    protected $casts = [
        'type' => StudyType::class,
        'duration' => 'int',
        'start_year' => 'int',
        'end_year' => 'int',
    ];
}
