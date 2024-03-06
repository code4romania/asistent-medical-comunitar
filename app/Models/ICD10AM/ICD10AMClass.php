<?php

declare(strict_types=1);

namespace App\Models\ICD10AM;

use App\Concerns\ModelAsOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class ICD10AMClass extends Model
{
    use ModelAsOptions;

    public $timestamps = false;

    protected $table = 'icd10am_classes';

    protected $fillable = [
        'id', 'name',
    ];

    public function subclasses(): HasMany
    {
        return $this->hasMany(ICD10AMSubclass::class, 'class_id');
    }

    public function diagnostics(): HasManyThrough
    {
        return $this->hasManyThrough(
            related: ICD10AMDiagnostic::class,
            through: ICD10AMSubclass::class,
            firstKey: 'class_id',
            secondKey: 'subclass_id'
        );
    }
}
