<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToNurse;
use App\Enums\VacationType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Vacation extends Model
{
    use BelongsToNurse;
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'type',
        'start_date',
        'end_date',
        'notes',
    ];

    protected $casts = [
        'type' => VacationType::class,
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

    public function scopeWhereMedical(Builder $query): Builder
    {
        return $query->where('type', VacationType::MEDICAL);
    }

    public function scopeWhereRest(Builder $query): Builder
    {
        return $query->where('type', VacationType::REST);
    }

    public function scopeWhereChild(Builder $query): Builder
    {
        return $query->where('type', VacationType::CHILD);
    }

    public function scopeWhereSpecial(Builder $query): Builder
    {
        return $query->where('type', VacationType::SPECIAL);
    }

    public function scopeWhereBloodDonation(Builder $query): Builder
    {
        return $query->where('type', VacationType::BLOOD_DONATION);
    }

    public function scopeWhereOther(Builder $query): Builder
    {
        return $query->where('type', VacationType::OTHER);
    }
}
