<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\Report\Status;
use App\Models\Report;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Throwable;

class CompareReportsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reports:compare
                            {first? : Report id; on its own, it is compared with the previous matching report}
                            {second? : Report id to compare the first one against}
                            {--all : Without ids, compare the latest two reports of every matching set, not just the newest set}
                            {--since= : With --all, only consider reports created from this moment on}
                            {--diff : Print the differing values of every pair that has differences}
                            {--limit= : With --diff, how many differences to print for each pair (default: all)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compare the data of two reports that share type, category, date range, indicators and user, by default the newest report and the one before it';

    /**
     * Every column needed to group reports, but not the (heavy) data column.
     *
     * @var list<string>
     */
    protected const array LISTING_COLUMNS = [
        'id',
        'created_at',
        'status',
        'type',
        'category',
        'date_from',
        'date_until',
        'indicators',
        'user_id',
    ];

    protected const string PATH_SEPARATOR = ' › ';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $pairs = $this->resolvePairs();

        if ($pairs === null) {
            return self::FAILURE;
        }

        if ($pairs->isEmpty()) {
            $this->warn($this->option('all') || filled($this->argument('first'))
                ? 'No two finished reports share the same type, category, date range, indicators and user.'
                : 'No finished report before the newest one shares its type, category, date range, indicators and user.');

            return self::SUCCESS;
        }

        $results = $pairs->map(fn (array $pair): array => $this->compare(...$pair));

        if ($this->option('diff')) {
            $this->printDifferences($results);
        }

        $this->printSummary($results);

        return self::SUCCESS;
    }

    /**
     * @return Collection<int, array{0: Report, 1: Report}>|null
     */
    protected function resolvePairs(): ?Collection
    {
        $firstId = $this->argument('first');
        $secondId = $this->argument('second');

        if (blank($firstId) && ! $this->option('all')) {
            return $this->newestPair();
        }

        if (blank($firstId)) {
            try {
                $since = filled($value = $this->option('since')) ? Carbon::parse($value) : null;
            } catch (Throwable $exception) {
                $this->error("Could not parse --since: {$exception->getMessage()}");

                return null;
            }

            return $this->latestPairs($since);
        }

        $first = $this->findReport($firstId);

        if (blank($first)) {
            return null;
        }

        if (blank($secondId)) {
            $previous = $this->previousMatchingReport($first);

            if (blank($previous)) {
                $this->error("No finished report created before {$first->id} matches its type, category, date range, indicators and user.");

                return null;
            }

            return collect([[$previous, $first]]);
        }

        $second = $this->findReport($secondId);

        if (blank($second)) {
            return null;
        }

        [$older, $newer] = $this->recency($first) <= $this->recency($second)
            ? [$first, $second]
            : [$second, $first];

        $this->warnAboutMismatches($older, $newer);

        return collect([[$older, $newer]]);
    }

    /**
     * The newest finished report and the one before it in the same set.
     *
     * @return Collection<int, array{0: Report, 1: Report}>
     */
    protected function newestPair(): Collection
    {
        $newest = Report::query()
            ->select(self::LISTING_COLUMNS)
            ->where('status', Status::FINISHED)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->first();

        $previous = filled($newest)
            ? $this->previousMatchingReport($newest)
            : null;

        return filled($previous)
            ? collect([[$previous, $newest]])
            : collect();
    }

    /**
     * Streams every finished report and keeps the newest two of each group, so the
     * whole table never has to sit in memory at once.
     *
     * @return Collection<int, array{0: Report, 1: Report}>
     */
    protected function latestPairs(?Carbon $since): Collection
    {
        $groups = [];

        Report::query()
            ->select(self::LISTING_COLUMNS)
            ->where('status', Status::FINISHED)
            ->when($since, fn (Builder $query, Carbon $since): Builder => $query->where('created_at', '>=', $since))
            ->lazyById(1000)
            ->each(function (Report $report) use (&$groups): void {
                $key = $this->comparisonKey($report);

                $groups[$key] = collect($groups[$key] ?? [])
                    ->push($report)
                    ->sortByDesc(fn (Report $report): string => $this->recency($report))
                    ->take(2)
                    ->values()
                    ->all();
            });

        return collect($groups)
            ->filter(fn (array $reports): bool => \count($reports) === 2)
            ->map(fn (array $reports): array => [$reports[1], $reports[0]])
            ->sortBy(fn (array $pair): string => $this->recency($pair[1]))
            ->values();
    }

    protected function previousMatchingReport(Report $report): ?Report
    {
        $key = $this->comparisonKey($report);

        return Report::query()
            ->select(self::LISTING_COLUMNS)
            ->where('status', Status::FINISHED)
            ->whereKeyNot($report->getKey())
            ->where('type', $report->type)
            ->where('user_id', $report->user_id)
            ->when(
                $report->category,
                fn (Builder $query, $category): Builder => $query->where('category', $category),
                fn (Builder $query): Builder => $query->whereNull('category'),
            )
            ->when(
                $report->date_from,
                fn (Builder $query, $date): Builder => $query->whereDate('date_from', $date),
                fn (Builder $query): Builder => $query->whereNull('date_from'),
            )
            ->when(
                $report->date_until,
                fn (Builder $query, $date): Builder => $query->whereDate('date_until', $date),
                fn (Builder $query): Builder => $query->whereNull('date_until'),
            )
            ->get()
            ->filter(fn (Report $candidate): bool => $this->comparisonKey($candidate) === $key)
            ->filter(fn (Report $candidate): bool => $this->recency($candidate) < $this->recency($report))
            ->sortByDesc(fn (Report $candidate): string => $this->recency($candidate))
            ->first();
    }

    protected function findReport(string $id): ?Report
    {
        $report = Report::query()
            ->select(self::LISTING_COLUMNS)
            ->find($id);

        if (blank($report)) {
            $this->error("No report has id {$id}.");

            return null;
        }

        if (! $report->isFinished()) {
            $this->warn("Report {$report->id} is {$report->status->value}, so its data may be missing or partial.");
        }

        return $report;
    }

    protected function warnAboutMismatches(Report $older, Report $newer): void
    {
        $mismatches = collect($this->comparisonFields($older))
            ->reject(fn (mixed $value, string $field): bool => $value === data_get($this->comparisonFields($newer), $field))
            ->keys();

        if ($mismatches->isNotEmpty()) {
            $this->warn("These reports differ in {$mismatches->implode(', ')}, so their data is not expected to match.");
        }
    }

    /**
     * @return array{type: ?string, category: ?string, date_from: ?string, date_until: ?string, indicators: list<string>, user_id: ?int}
     */
    protected function comparisonFields(Report $report): array
    {
        return [
            'type' => $report->type->value,
            'category' => $report->category?->value,
            'date_from' => $report->date_from?->toDateString(),
            'date_until' => $report->date_until?->toDateString(),
            // Labels are translations and may drift; the indicator keys are what the report runs.
            'indicators' => collect($report->indicators)->keys()->sort()->values()->all(),
            'user_id' => $report->user_id,
        ];
    }

    protected function comparisonKey(Report $report): string
    {
        return json_encode($this->comparisonFields($report));
    }

    /**
     * Sortable string ordering reports by creation, with the id breaking ties.
     */
    protected function recency(Report $report): string
    {
        return $report->created_at?->format('Y-m-d H:i:s.u') . '|' . $report->id;
    }

    /**
     * @return array{older: Report, newer: Report, differences: Collection<int, array{0: string, 1: string, 2: string}>}
     */
    protected function compare(Report $older, Report $newer): array
    {
        $before = $this->flatten($this->loadData($older));
        $after = $this->flatten($this->loadData($newer));

        $differences = collect(array_keys($before + $after))
            ->reject(fn (string $path): bool => \array_key_exists($path, $before)
                && \array_key_exists($path, $after)
                && $this->isSameValue($before[$path], $after[$path]))
            ->map(fn (string $path): array => [
                OutputFormatter::escape($path),
                $this->formatValue($before, $path),
                $this->formatValue($after, $path),
            ])
            ->values();

        return [
            'older' => $older,
            'newer' => $newer,
            'differences' => $differences,
        ];
    }

    /**
     * Loads the data on its own, so the listed reports never hold every dataset at once.
     *
     * @return array<array-key, mixed>
     */
    protected function loadData(Report $report): array
    {
        $data = Report::query()->whereKey($report->getKey())->value('data');

        return $data instanceof Collection ? $data->all() : [];
    }

    /**
     * @param  array<array-key, mixed> $data
     * @return array<string, mixed>
     */
    protected function flatten(array $data, string $prefix = ''): array
    {
        $flattened = [];

        foreach ($data as $key => $value) {
            $path = $prefix === '' ? (string) $key : $prefix . self::PATH_SEPARATOR . $key;

            if (\is_array($value) && $value !== []) {
                $flattened += $this->flatten($value, $path);

                continue;
            }

            $flattened[$path] = $value;
        }

        return $flattened;
    }

    /**
     * Numbers compare by value, since the same result may come back as 3, 3.0 or "3".
     */
    protected function isSameValue(mixed $before, mixed $after): bool
    {
        if (is_numeric($before) && is_numeric($after)) {
            return abs((float) $before - (float) $after) < 1e-9;
        }

        return $before === $after;
    }

    /**
     * @param array<string, mixed> $values
     */
    protected function formatValue(array $values, string $path): string
    {
        if (! \array_key_exists($path, $values)) {
            return '<fg=gray>missing</>';
        }

        $value = $values[$path];

        return OutputFormatter::escape(match (true) {
            $value === null => 'null',
            \is_bool($value) => $value ? 'true' : 'false',
            \is_array($value) => json_encode($value),
            default => (string) $value,
        });
    }

    protected function describe(Report $report): string
    {
        return \sprintf(
            '%s %s, %s – %s, user #%s, %d indicator(s)',
            $report->type->value,
            $report->category?->value ?? '—',
            $report->date_from?->toDateString() ?? '—',
            $report->date_until?->toDateString() ?? '—',
            $report->user_id ?? '—',
            collect($report->indicators)->count(),
        );
    }

    /**
     * @param Collection<int, array{older: Report, newer: Report, differences: Collection<int, array{0: string, 1: string, 2: string}>}> $results
     */
    protected function printDifferences(Collection $results): void
    {
        $limit = filled($this->option('limit'))
            ? max(1, (int) $this->option('limit'))
            : \PHP_INT_MAX;

        $results
            ->filter(fn (array $result): bool => $result['differences']->isNotEmpty())
            ->each(function (array $result) use ($limit): void {
                $this->newLine();
                $this->line(\sprintf('  <options=bold>%s</>', $this->describe($result['newer'])));
                $this->line(\sprintf(
                    '  %s (%s) → %s (%s)',
                    $result['older']->id,
                    $result['older']->created_at?->toDateTimeString(),
                    $result['newer']->id,
                    $result['newer']->created_at?->toDateTimeString(),
                ));

                $this->table(
                    ['Path', 'Older', 'Newer'],
                    $result['differences']->take($limit)->all(),
                );

                if ($result['differences']->count() > $limit) {
                    $this->line(\sprintf(
                        '  … and %d more. Pass --limit to see them.',
                        $result['differences']->count() - $limit,
                    ));
                }
            });
    }

    /**
     * @param Collection<int, array{older: Report, newer: Report, differences: Collection<int, array{0: string, 1: string, 2: string}>}> $results
     */
    protected function printSummary(Collection $results): void
    {
        $this->newLine();

        $this->table(
            ['Older', 'Newer', 'Type', 'Category', 'Period', 'User', 'Result'],
            $results->map(fn (array $result): array => [
                $result['older']->id,
                $result['newer']->id,
                $result['newer']->type->value,
                $result['newer']->category?->value,
                $result['newer']->period,
                $result['newer']->user_id,
                $result['differences']->isEmpty()
                    ? '<fg=green>identical</>'
                    : \sprintf('<fg=red>%d difference(s)</>', $result['differences']->count()),
            ])->all(),
        );

        $identical = $results->filter(fn (array $result): bool => $result['differences']->isEmpty())->count();

        $this->line(\sprintf(
            '  <options=bold>%d</> of <options=bold>%d</> pair(s) identical.',
            $identical,
            $results->count(),
        ));

        if ($identical < $results->count() && ! $this->option('diff')) {
            $this->line('  Pass --diff to see what differs.');
        }
        $this->newLine();
    }
}
