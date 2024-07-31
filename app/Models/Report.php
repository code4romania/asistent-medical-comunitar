<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Report\Type;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;

class Report extends Model
{
    use HasUuids;
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'date_from',
        'date_until',
        'columns',
        'data',
        'user_id',
    ];

    protected $casts = [
        'type' => Type::class,
        'date_from' => 'date',
        'date_until' => 'date',
        'columns' => 'collection',
        'data' => 'collection',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('forCurrentUser', function (Builder $builder) {
            if (! auth()->check()) {
                return;
            }

            $builder->whereBelongsTo(auth()->user());
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getSegmentTuplesAttribute(): array
    {
        $segments = $this->segments
            ->map(function (array $values, string $indicator) {
                return collect($values)
                    ->map(fn ($value) => $indicator . '.' . $value)
                    ->all();
            })
            ->filter()
            ->values()
            ->all();

        return Arr::crossJoin(...$segments);
    }

    public function isList(): Attribute
    {
        return Attribute::make(
            fn () => $this->type->is(Type::LIST),
        );
    }

    public function isStatistic(): Attribute
    {
        return Attribute::make(
            fn () => $this->type->is(Type::STATISTIC),
        );
    }
}
