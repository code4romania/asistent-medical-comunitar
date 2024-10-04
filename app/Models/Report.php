<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\Enums\HasQuery;
use App\Enums\Report\Standard\Category;
use App\Enums\Report\Status;
use App\Enums\Report\Type;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Report extends Model
{
    use HasUuids;
    use HasFactory;

    protected $fillable = [
        'category',
        'type',
        'status',
        'title',
        'date_from',
        'date_until',
        'columns',
        'indicators',
        'data',
        'user_id',
    ];

    protected $casts = [
        'category' => Category::class,
        'type' => Type::class,
        'status' => Status::class,
        'date_from' => 'date',
        'date_until' => 'date',
        'columns' => 'collection',
        'indicators' => 'collection',
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

        static::creating(function (self $report) {
            if (blank($report->type)) {
                $report->type = Type::STATISTIC;
            }

            if (auth()->check()) {
                $report->user_id = auth()->id();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getPeriodAttribute(): string
    {
        return collect([
            $this->date_from,
            $this->date_until,
        ])
            ->filter()
            ->map(fn (Carbon $date) => $date->toFormattedDate())
            ->implode(' - ');
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

    public function isList(): bool
    {
        return $this->type->is(Type::LIST);
    }

    public function isStatistic(): bool
    {
        return $this->type->is(Type::STATISTIC);
    }

    public function isFinished(): bool
    {
        return $this->status->is(Status::FINISHED);
    }

    public function isPending(): bool
    {
        return $this->status->is(Status::PENDING);
    }

    public function isFailed(): bool
    {
        return $this->status->is(Status::FAILED);
    }

    public function indicators(): Collection
    {
        return $this->indicators
            ->map(fn (string $indicator) => $this->category->indicators()::from($indicator))
            ->reject(fn (HasQuery $indicator) => ! class_exists($indicator->class()));
    }
}
