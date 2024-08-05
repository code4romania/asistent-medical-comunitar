<?php

declare(strict_types=1);

namespace App\Reports\Standard;

use App\Exceptions\InvalidReportTypeException;
use App\Models\Report;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class StandardReport
{
    abstract public function query(): Builder;

    abstract public function dateColumn(): string;

    abstract public function columns(): array;

    protected Report $report;

    public function __construct(array $data)
    {
        $this->report = Report::make($data);

        $this->report->columns = collect(
            $this->report->isList
                ? collect($this->columns())
                    ->map(fn (string $label, string $key) => [
                        'name' => $key,
                        'label' => $label,
                    ])
                    ->values()
                : null
        );
    }

    public static function make(array $data): Report
    {
        $static = app(static::class, ['data' => $data]);

        return $static->handle();
    }

    final public function handle(): Report
    {
        $query = $this->query()
            ->select($this->report->columns->pluck('name')->all())
            ->when(
                $this->report->date_until,
                fn (Builder $query) => $query
                    ->whereDate($this->dateColumn(), '>=', $this->report->date_from)
                    ->whereDate($this->dateColumn(), '<=', $this->report->date_until),
                fn (Builder $query) => $query
                    ->whereDate($this->dateColumn(), '=', $this->report->date_from)
            );

        $this->report->data = match (true) {
            $this->report->isStatistic => $this->handleStatistic($query),
            $this->report->isList => $this->handleList($query),
            default => throw new InvalidReportTypeException,
        };

        return $this->report;
    }

    final protected function handleStatistic(Builder $query): Collection
    {
        return collect([
            $this->report->title => [$query->count()],
        ]);
    }

    final protected function handleList(Builder $query): Collection
    {
        return $query
            ->get()
            ->map(
                fn (Model $record) => $this->report->columns
                    ->mapWithKeys(fn (array $column) => [
                        $column['name'] => match ($column['name']) {
                            'date_of_birth' => $record->age,
                            'gender', 'status' => $record->{$column['name']}?->label(),
                            default => $record->{$column['name']},
                        },
                    ])
                    ->put('actions', $this->getRecordActions([
                        'record' => $record,
                    ]))
            );
    }

    public function getRecordActions(array $params = []): array
    {
        return [];
    }
}
