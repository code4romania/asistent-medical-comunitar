<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Report\Type;
use App\Models\Scopes\CurrentUserScope;
use App\Reports\NurseActivityReport;
use App\Reports\ReportData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
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

    public function data(): ReportData
    {
        $report = NurseActivityReport::class;

        return new $report($this);
    }

    public function getIndicatorsListAttribute(): ?string
    {
        if ($this->indicators === null) {
            return null;
        }

        return $this->indicators
            ->flatMap(
                fn (array $indicators, string $group) => array_map(
                    fn ($indicator) => __(sprintf('report.indicator.%s.value.%s', $group, $indicator)),
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
                    fn ($segment) => __(sprintf('report.segment.%s.value.%s', $group, $segment)),
                    $segments
                )
            )
            ->join(', ');
    }
}
