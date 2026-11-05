<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToUser;
use App\Contracts\Enums\HasQuery;
use App\Enums\Report\Standard\Category;
use App\Enums\Report\Status;
use App\Enums\Report\Type;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Report extends Model
{
    use BelongsToUser;
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
        static::creating(function (self $report) {
            if (blank($report->type)) {
                $report->type = Type::STATISTIC;
            }

            if (auth()->check()) {
                $report->user_id = auth()->id();
            }
        });
    }

    public function restrictScopeToCurrentUser(): bool
    {
        return true;
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

    public function getIndicators(): Collection
    {
        return $this->indicators
            ->keys()
            ->map(fn (string $indicator): ?HasQuery => $this->category->indicator()::from($indicator))
            ->reject(fn (?HasQuery $indicator) => blank($indicator) || ! class_exists($indicator->class()));
    }

    public function title(): Attribute
    {
        return Attribute::make(
            get: fn () => \sprintf(
                'Raport %s %s %s',
                Str::lower($this->type->getLabel()),
                $this->category->getLabel(),
                $this->period,
            ),
        );
    }

    public function datetimeFrom(): Attribute
    {
        return Attribute::make(
            get: fn (): Carbon => $this->date_from->startOfDay()
        );
    }

    public function datetimeUntil(): Attribute
    {
        return Attribute::make(
            get: fn (): Carbon => $this->date_until->endOfDay()
        );
    }
}
