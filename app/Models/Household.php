<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToNurse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Household extends Model
{
    use BelongsToNurse;
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'name',
    ];

    public function families(): HasMany
    {
        return $this->hasMany(Family::class);
    }

    public function beneficiaries(): HasManyThrough
    {
        return $this->hasManyThrough(Beneficiary::class, Family::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->dontSubmitEmptyLogs()
            ->logFillable()
            ->logOnlyDirty();
    }

    public static function createForCurrentNurse(array $data): self
    {
        $data['nurse_id'] = auth()->id();

        return self::create($data);
    }
}
