<?php

declare(strict_types=1);

namespace App\Models\Orpha;

use App\Concerns\HasInterventions;
use App\Concerns\ModelAsOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Znck\Eloquent\Traits\BelongsToThrough as BelongsToThroughTrait;

class OrphaDiagnostic extends Model
{
    use BelongsToThroughTrait;
    use ModelAsOptions;
    use HasInterventions;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'code',
        'name',
        'classification_level_id',
    ];

    public function classificationLevel(): BelongsTo
    {
        return $this->belongsTo(OrphaClassificationLevel::class);
    }
}
