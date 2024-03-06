<?php

declare(strict_types=1);

namespace App\Models\ICD10AM;

use App\Concerns\ModelAsOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ICD10AMSubclass extends Model
{
    use ModelAsOptions;

    public $timestamps = false;

    protected $table = 'icd10am_subclasses';

    protected $fillable = [
        'id', 'name', 'class_id',
    ];

    public function class(): BelongsTo
    {
        return $this->belongsTo(ICD10AMClass::class, 'class_id');
    }

    public function diagnostics(): HasMany
    {
        return $this->hasMany(ICD10AMDiagnostic::class, 'subclass_id');
    }
}
