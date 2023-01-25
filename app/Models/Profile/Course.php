<?php

declare(strict_types=1);

namespace App\Models\Profile;

use App\Concerns\HasLocation;
use App\Enums\CourseType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    use HasLocation;

    protected $table = 'profile_courses';

    protected $fillable = [
        'name',
        'theme',
        'provider',
        'type',
        'credits',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'type' => CourseType::class,
        'credits' => 'int',
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}
