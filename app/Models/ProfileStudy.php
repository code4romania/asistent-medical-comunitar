<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfileStudy extends Model
{
    use HasFactory;
    protected $with=['city','county'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
    public function county(): BelongsTo
    {
        return $this->belongsTo(County::class);
    }
}
