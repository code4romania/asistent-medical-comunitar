<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToUser;
use App\Concerns\HasLocation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Feedback extends Model
{
    use BelongsToUser;
    use HasFactory;
    use HasLocation;
    use LogsActivity;

    public const UPDATED_AT = null;

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'description',
    ];

    public static function booted(): void
    {
        static::creating(function (self $feedback): void {
            $feedback->county_id = auth()->user()->activity_county_id;
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->dontSubmitEmptyLogs()
            ->logFillable()
            ->logOnlyDirty();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(FeedbackCategory::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(FeedbackSubcategory::class);
    }

    public function scopeForUser(Builder $query, User $user): Builder
    {
        if ($user->isNurseOrMediator()) {
            return $query->where('user_id', $user->id);
        }

        return $query;
    }
}
