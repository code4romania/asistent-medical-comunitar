<?php

declare(strict_types=1);

namespace App\Models\Orpha;

use App\Concerns\ModelAsOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrphaClassificationLevel extends Model
{
    use ModelAsOptions;

    public $timestamps = false;

    protected $fillable = [
        'id', 'name',
    ];

    public function diagnostics(): HasMany
    {
        return $this->hasMany(OrphaDiagnostic::class);
    }
}
