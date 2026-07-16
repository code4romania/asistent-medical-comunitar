<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToBeneficiary;
use App\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Document extends Model implements HasMedia
{
    use BelongsToBeneficiary;
    use BelongsToUser;
    use HasFactory;
    use InteractsWithMedia;
    use LogsActivity;

    protected $fillable = [
        'title',
        'type',
        'notes',
    ];

    protected static function booted(): void
    {
        // A mediator only sees documents they uploaded themselves; nurses see
        // every document of a beneficiary they can access.
        static::addGlobalScope('forCurrentUser', function (Builder $builder): void {
            if (auth()->user()?->isMediator()) {
                $builder->where('documents.user_id', auth()->id());
            }
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->dontSubmitEmptyLogs()
            ->logFillable()
            ->logOnlyDirty();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')
            ->singleFile();
    }
}
