<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function beneficiaries(): BelongsToMany
    {
        return $this->belongsToMany(Beneficiary::class);
    }

    public function household(): BelongsTo
    {
        return $this->belongsTo(Household::class);
    }
}
