<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Contracts\Enums\HasQuery;
use App\Enums\Report\Standard\Category;
use App\Enums\Report\Type;
use App\Enums\User\Role;
use App\Jobs\GenerateReport\Standard\GenerateStandardReportJob;
use App\Models\County;
use App\Models\Report;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Helper\ProgressBar;
use Throwable;

class GenerateAllReportsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reports:generate-all
                            {--role=* : Restrict to these roles}
                            {--category=* : Restrict to these report categories}
                            {--type=* : Restrict to these report types}
                            {--user= : Pin the acting user by id or email; narrows the run to that user role}
                            {--from= : Start of the report date range (default: the start of the current year)}
                            {--until= : End of the report date range (default: today)}
                            {--counties= : Cap how many counties the admin reports segment by}
                            {--nurses= : Cap how many nurses the coordinator reports segment by}
                            {--indicators= : Cap how many indicators each report covers}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate every valid standard report combination and dispatch the queued jobs, to smoke-test the report queries';

    protected ProgressBar $progressBar;

    protected Carbon $startedAt;

    protected Carbon $dateFrom;

    protected Carbon $dateUntil;

    protected ?User $pinnedUser = null;

    protected Collection $roles;

    protected Collection $categories;

    protected Collection $types;

    protected array $caps = [];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->startedAt = now();

        if (! $this->resolveOptions()) {
            return self::FAILURE;
        }

        $this->printSettings();

        $plan = $this->buildPlan();

        if ($plan->isEmpty()) {
            $this->warn('There is nothing to generate.');

            return self::SUCCESS;
        }

        $rows = $this->generate($plan);

        Auth::forgetUser();

        $this->printSummary($rows);

        return self::SUCCESS;
    }

    protected function resolveOptions(): bool
    {
        if (! $this->resolveDateRange() || ! $this->resolveCaps()) {
            return false;
        }

        $roles = $this->resolveEnumOption('role', Role::class);
        $categories = $this->resolveEnumOption('category', Category::class);
        $types = $this->resolveEnumOption('type', Type::class);

        if (blank($roles) || blank($categories) || blank($types)) {
            return false;
        }

        $this->roles = $roles;
        $this->categories = $categories;
        $this->types = $types;

        return $this->resolvePinnedUser();
    }

    protected function resolveDateRange(): bool
    {
        try {
            $this->dateFrom = filled($from = $this->option('from'))
                ? Carbon::parse($from)->startOfDay()
                : now()->startOfYear();

            $this->dateUntil = filled($until = $this->option('until'))
                ? Carbon::parse($until)->startOfDay()
                : today();
        } catch (Throwable $exception) {
            $this->error("Could not parse the date range: {$exception->getMessage()}");

            return false;
        }

        if ($this->dateUntil->isAfter(today())) {
            $this->warn(\sprintf(
                'The form caps the range at today, so --until=%s was clamped to %s.',
                $this->dateUntil->toDateString(),
                today()->toDateString(),
            ));

            $this->dateUntil = today();
        }

        if ($this->dateFrom->isAfter($this->dateUntil)) {
            $this->error(\sprintf(
                'The start of the range (%s) is after its end (%s).',
                $this->dateFrom->toDateString(),
                $this->dateUntil->toDateString(),
            ));

            return false;
        }

        return true;
    }

    protected function resolveCaps(): bool
    {
        foreach (['counties', 'nurses', 'indicators'] as $option) {
            $value = $this->option($option);

            if (blank($value)) {
                continue;
            }

            if (! ctype_digit((string) $value) || (int) $value < 1) {
                $this->error("The --{$option} cap must be a positive integer.");

                return false;
            }

            $this->caps[$option] = (int) $value;
        }

        return true;
    }

    protected function resolveEnumOption(string $option, string $enum): ?Collection
    {
        $allowed = collect($enum::cases());

        $values = collect($this->option($option));

        if ($values->isEmpty()) {
            return $allowed->values();
        }

        $unknown = $values->reject(fn (string $value): bool => $allowed->has($value));

        if ($unknown->isNotEmpty()) {
            $this->error(\sprintf(
                'Unknown --%s value(s): %s. Allowed: %s.',
                $option,
                $unknown->implode(', '),
                $allowed->keys()->implode(', '),
            ));

            return null;
        }

        return $allowed->only($values->all())->values();
    }

    protected function resolvePinnedUser(): bool
    {
        $value = $this->option('user');

        if (blank($value)) {
            return true;
        }

        $this->pinnedUser = User::query()
            ->when(
                (int) $value,
                fn (Builder $query, $value): Builder => $query->whereKey($value),
                fn (Builder $query, $value): Builder => $query->where('email', $value),
            )
            ->first();

        if (blank($this->pinnedUser)) {
            $this->error("No user matches --user={$value}.");

            return false;
        }

        if (blank($this->pinnedUser->role)) {
            $this->error("The user pinned with --user={$value} has no role.");

            return false;
        }

        if (! $this->roles->contains($this->pinnedUser->role)) {
            $this->error(\sprintf(
                'The user pinned with --user=%s is a %s, which --role excludes.',
                $value,
                $this->pinnedUser->role->value,
            ));

            return false;
        }

        $this->roles = collect([$this->pinnedUser->role]);

        return true;
    }

    protected function buildPlan(): Collection
    {
        return $this->roles->flatMap(function (Role $role): array {
            $user = $this->resolveActingUser($role);

            if (blank($user)) {
                $this->warn("Skipping {$role->value}: no active user has that role.");

                return [];
            }

            Auth::setUser($user);

            $segments = $this->resolveSegments($role, $user);

            if ($segments === null) {
                return [];
            }

            $combinations = $this->resolveCombinations($user);

            if ($combinations->isEmpty()) {
                $this->warn("Skipping {$role->value}: no combination matches the filters.");

                return [];
            }

            return $combinations
                ->map(fn (array $combination): array => [
                    'role' => $role,
                    'user' => $user,
                    'type' => $combination['type'],
                    'category' => $combination['category'],
                    'segments' => $segments,
                ])
                ->all();
        });
    }

    protected function resolveActingUser(Role $role): ?User
    {
        if (filled($this->pinnedUser)) {
            return $this->pinnedUser;
        }

        return match ($role) {
            Role::ADMIN => $this->activeUsers($role)->first(),
            Role::COORDINATOR => $this->resolveCoordinator(),
            Role::NURSE, Role::MEDIATOR => $this->resolveNurseOrMediator($role),
        };
    }

    protected function activeUsers(Role $role): Builder
    {
        return User::query()
            ->where('role', $role)
            ->onlyActive()
            ->orderBy('id');
    }

    protected function resolveCoordinator(): ?User
    {
        $countiesWithNurses = User::query()
            ->onlyNurses()
            ->distinct()
            ->pluck('activity_county_id')
            ->filter();

        return $this->activeUsers(Role::COORDINATOR)
            ->whereIn('county_id', $countiesWithNurses)
            ->first()
            ?? $this->activeUsers(Role::COORDINATOR)->first();
    }

    protected function resolveNurseOrMediator(Role $role): ?User
    {
        $relation = $role->is(Role::MEDIATOR)
            ? 'mediatedBeneficiaries'
            : 'beneficiaries';

        return $this->activeUsers($role)
            ->whereHas($relation)
            ->first()
            ?? $this->activeUsers($role)->first();
    }

    protected function resolveSegments(Role $role, User $user): ?array
    {
        if ($role->is(Role::ADMIN)) {
            $counties = $this->applyCap(
                County::query()->orderBy('id')->pluck('id'),
                'counties'
            );

            if ($counties->isEmpty()) {
                $this->warn('Skipping admin: there are no counties to segment by.');

                return null;
            }

            return ['counties' => $counties->all()];
        }

        if ($role->is(Role::COORDINATOR)) {
            $nurses = $this->applyCap(
                User::query()
                    ->onlyNurses()
                    ->activatesInCurrentUserCounty()
                    ->withActivityAreas()
                    ->get()
                    ->sortBy('id')
                    ->pluck('id'),
                'nurses'
            );

            // The form's nurses select is minItems(1), so an empty list is not a report a user
            // could have submitted.
            if ($nurses->isEmpty()) {
                $this->warn(\sprintf(
                    'Skipping coordinator %s: %s.',
                    $user->email,
                    blank($user->county_id)
                        ? 'they have no county, so the form would offer no nurses'
                        : 'no nurses activate in their county',
                ));

                return null;
            }

            return ['nurses' => $nurses->all()];
        }

        return [];
    }

    protected function applyCap(Collection $ids, string $option): Collection
    {
        return $ids
            ->when(
                data_get($this->caps, $option),
                fn (Collection $ids, int $cap): Collection => $ids->take($cap)
            )
            ->values();
    }

    protected function resolveCombinations(User $user): Collection
    {
        // The type field is only visible to nurses and mediators; for everyone else it stays unset
        // and Report::booted() defaults it to STATISTIC, which is what --type filters against.
        if (! $user->isNurseOrMediator()) {
            return $this->types->contains(Type::STATISTIC)
                ? collect($this->categoriesVisibleTo(null))
                : collect();
        }

        return $this->types->flatMap(
            fn (Type $type): array => $this->categoriesVisibleTo($type)
        );
    }

    protected function categoriesVisibleTo(?Type $type): array
    {
        return $this->categories
            ->filter(fn (Category $category): bool => $category->isVisible($type))
            ->map(fn (Category $category): array => [
                'type' => $type,
                'category' => $category,
            ])
            ->values()
            ->all();
    }

    protected function generate(Collection $plan): Collection
    {
        $this->newLine();

        $this->progressBar = $this->output->createProgressBar($plan->count());
        $this->progressBar->start();

        $rows = $plan->map(function (array $entry): array {
            Auth::setUser($entry['user']);

            $data = $this->buildData($entry);

            $report = new Report($data);
            $report->save();

            GenerateStandardReportJob::dispatchFor($entry['role'], $report, $data);

            $this->progressBar->advance();

            $segments = collect($entry['segments'])->flatten();

            return [
                $report->id,
                $entry['role']->value,
                $report->type->value,
                $entry['category']->value,
                \count($data['indicators']),
                $segments->isEmpty() ? '—' : $segments->count(),
            ];
        });

        $this->progressBar->finish();
        $this->newLine(2);

        return $rows;
    }

    protected function buildData(array $entry): array
    {
        $data = [
            'category' => $entry['category'],
            'date_from' => $this->dateFrom->toDateString(),
            'date_until' => $this->dateUntil->toDateString(),
            'indicators' => $this->buildIndicators($entry['category']),
        ];

        if (filled($entry['type'])) {
            $data['type'] = $entry['type'];
        }

        // counties and nurses are not columns on reports: they reach segmentation only through
        // the payload the job constructor receives.
        return array_merge($data, $entry['segments']);
    }

    protected function buildIndicators(Category $category): array
    {
        return collect($category->indicator()::cases())
            ->reject(fn (HasQuery $indicator): bool => ! class_exists($indicator->class()))
            ->when(
                data_get($this->caps, 'indicators'),
                fn (Collection $indicators, int $cap): Collection => $indicators->take($cap)
            )
            ->mapWithKeys(fn (HasQuery $indicator): array => [
                $indicator->value => $indicator->getLabel(),
            ])
            ->all();
    }

    protected function printSettings(): void
    {
        $this->newLine();
        $this->line('  <options=bold>Effective settings</>');
        $this->line(\sprintf('    Date range  %s → %s', $this->dateFrom->toDateString(), $this->dateUntil->toDateString()));
        $this->line(\sprintf('    Roles       %s', $this->describeSelection($this->roles, Role::cases())));
        $this->line(\sprintf('    Types       %s', $this->describeSelection($this->types, Type::cases())));
        $this->line(\sprintf('    Categories  %s', $this->describeSelection($this->categories, Category::cases())));
        $this->line(\sprintf('    Counties    %s', data_get($this->caps, 'counties', 'all')));
        $this->line(\sprintf('    Nurses      %s', data_get($this->caps, 'nurses', 'all')));
        $this->line(\sprintf('    Indicators  %s', data_get($this->caps, 'indicators', 'all')));

        if (filled($this->pinnedUser)) {
            $this->line(\sprintf('    User        %s (pinned)', $this->pinnedUser->email));
        }

        if (data_get($this->caps, 'counties') === 1 || data_get($this->caps, 'nurses') === 1) {
            $this->newLine();
            $this->warn('  Capping segments to 1 changes the output shape: generateDataset() only');
            $this->warn('  computes totals for more than one segment, so this run does not exercise');
            $this->warn('  the totals path.');
        }
    }

    protected function describeSelection(Collection $selected, array $all): string
    {
        return $selected->count() === \count($all)
            ? 'all'
            : $selected->pluck('value')->implode(', ');
    }

    protected function printSummary(Collection $rows): void
    {
        $this->table(
            ['Report', 'Role', 'Type', 'Category', 'Indicators', 'Segments'],
            $rows->all(),
        );

        $this->line(\sprintf('  <options=bold>%d</> report(s) created and dispatched.', $rows->count()));
        $this->newLine();
        $this->line(\sprintf(
            '  The jobs only run while a worker is processing the "%s" queue:',
            config('queue.reports_queue_name'),
        ));
        $this->line('    php artisan queue:work --stop-when-empty');
        $this->newLine();
        $this->line('  Each report then lands in "finished" or "failed". To see how the run went:');
        $this->line(\sprintf(
            "    select status, count(*) from reports where created_at >= '%s' group by status;",
            $this->startedAt->toDateTimeString(),
        ));
        $this->newLine();
    }
}
