<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Family extends Model
{
    protected $fillable = [
            'name'
        ];
    use HasFactory;

    public function beneficiaries(): BelongsToMany
    {
        return $this->belongsToMany(Beneficiary::class);
    }

    public function household(): BelongsTo
    {
        return $this->belongsTo(Household::class);
    }

}
