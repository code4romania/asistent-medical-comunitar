<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Report\Type;
use App\Models\Scopes\CurrentUserScope;
use App\Reports\NurseActivityReport;
use App\Reports\ReportFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Report extends Model
{
    use HasUuids;
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'date_from',
        'date_until',
        'indicators',
        'segments',
        'data',
        'user_id',
    ];

    protected $casts = [
        'type' => Type::class,
        'date_from' => 'date',
        'date_until' => 'date',
        'indicators' => 'collection',
        'segments' => 'collection',
        'data' => 'collection',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new CurrentUserScope);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function factory(): ReportFactory
    {
        $report = match ($this->type) {
            Type::NURSE_ACTIVITY => NurseActivityReport::class,
            default => NurseActivityReport::class,
        };

        return $report::make($this);
    }

    public function getTitleAttribute(): string
    {
        $title = [
            $this->type->label(),
        ];

        if ($this->segments->isNotEmpty()) {
            $title[] = __('report.title.segments', [
                'segments' => $this->segments
                    ->filter()
                    ->keys()
                    ->map(fn (string $segment) => Str::lower(__("report.column.{$segment}")))
                    ->implode(', '),
            ]);
        }

        if ($this->date_until === null) {
            $title[] = __('report.title.date', [
                'date' => $this->date_from->toFormattedDate(),
            ]);
        } else {
            $title[] = __('report.title.date_range', [
                'from' => $this->date_from->toFormattedDate(),
                'to' => $this->date_until->toFormattedDate(),
            ]);
        }

        return implode(' ', $title);
    }

    public function getIndicatorsListAttribute(): ?string
    {
        if ($this->indicators === null) {
            return null;
        }

        return $this->indicators
            ->flatMap(
                fn (array $indicators, string $group) => array_map(
                    fn ($indicator) => __(sprintf('report.indicator.value.%s.%s', $group, $indicator)),
                    $indicators
                )
            )
            ->join(', ');
    }

    public function getSegmentsListAttribute(): ?string
    {
        if ($this->segments === null) {
            return null;
        }

        return $this->segments
            ->flatMap(
                fn (array $segments, string $group) => array_map(
                    fn ($segment) => __(sprintf('report.segment.value.%s.%s', $group, $segment)),
                    $segments
                )
            )
            ->join(', ');
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
}
