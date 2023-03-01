<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Household extends Model
{
    use HasFactory;

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
}
