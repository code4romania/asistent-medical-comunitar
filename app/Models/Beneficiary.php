<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasLocation;
use App\Enums\Beneficiary\IDType;
use App\Enums\Beneficiary\Status;
use App\Enums\Beneficiary\Type;
use App\Enums\Gender;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Beneficiary extends Model
{
    use HasFactory;
    use HasLocation;

    protected $fillable = [
        'type',
        'status',
        'integrated',

        'first_name',
        'last_name',
        'prior_name',

        'cnp',
        'id_type',
        'id_serial',
        'id_number',

        'gender',
        'date_of_birth',

        'ethnicity',

        'address',
        'phone',
        'notes',

        'amc_id',
    ];

    protected $casts = [
        'type' => Type::class,
        'status' => Status::class,
        'id_type' => IDType::class,
        'gender' => Gender::class,
        'date_of_birth' => 'date',
    ];

    public function amc(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeOnlyRegular(Builder $query): Builder
    {
        return $query->where('type', Type::regular);
    }

    public function scopeOnlyOcasional(Builder $query): Builder
    {
        return $query->where('type', Type::ocasional);
    }

    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth?->age;
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
