<?php

declare(strict_types=1);

namespace App\Models\Profile;

use App\Concerns\HasLocation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Area extends Model
{
    use HasFactory;
    use HasLocation;
    use LogsActivity;

    protected $table = 'profile_areas';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['county.name', 'city.name'])
            ->logOnlyDirty();
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->description = "{$eventName} area";

        $activity->subject()->associate($activity->subject->user);
    }
}
