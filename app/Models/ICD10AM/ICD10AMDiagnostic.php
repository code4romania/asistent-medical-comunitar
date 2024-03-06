<?php

declare(strict_types=1);

namespace App\Models\ICD10AM;

use App\Concerns\HasInterventions;
use App\Concerns\ModelAsOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Znck\Eloquent\Relations\BelongsToThrough;
use Znck\Eloquent\Traits\BelongsToThrough as BelongsToThroughTrait;

class ICD10AMDiagnostic extends Model
{
    use BelongsToThroughTrait;
    use ModelAsOptions;
    use HasInterventions;

    public $timestamps = false;

    public $incrementing = false;

    protected $table = 'icd10am_diagnostics';

    protected $keyType = 'string';

    protected $fillable = [
        'id', 'name', 'subclass_id',
    ];

    public function class(): BelongsToThrough
    {
        return $this->belongsToThrough(
            related: ICD10AMClass::class,
            through: ICD10AMSubclass::class,
            foreignKeyLookup: [
                ICD10AMSubclass::class => 'subclass_id',
                ICD10AMClass::class => 'class_id',
            ]
        );
    }

    public function subclass(): BelongsTo
    {
        return $this->belongsTo(ICD10AMSubclass::class, 'subclass_id');
    }
}
