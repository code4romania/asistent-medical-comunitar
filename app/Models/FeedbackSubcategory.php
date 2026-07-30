<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\ModelAsOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedbackSubcategory extends Model
{
    use ModelAsOptions;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'category_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(FeedbackCategory::class, 'category_id');
    }
}
