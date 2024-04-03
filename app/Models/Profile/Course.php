<?php

declare(strict_types=1);

namespace App\Models\Profile;

use App\Enums\CourseType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Course extends Model
{
    use HasFactory;
    use LogsActivity;

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->dontSubmitEmptyLogs()
            ->logFillable()
            ->logOnlyDirty();
    }
}
