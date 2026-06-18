<?php

declare(strict_types=1);

namespace App\Filament\Widgets\StatsWidgets;

use App\Models\Appointment;
use App\Models\Beneficiary;
use App\Models\Intervention;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseStatsOverviewWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Tpetry\QueryExpressions\Function\Aggregate\CountFilter;
use Tpetry\QueryExpressions\Function\Conditional\Coalesce;
use Tpetry\QueryExpressions\Language\Alias;
use Tpetry\QueryExpressions\Language\Cast;
use Tpetry\QueryExpressions\Operator\Comparison\Between;
use Tpetry\QueryExpressions\Value\Value;

abstract class StatsOverviewWidget extends BaseStatsOverviewWidget
{
    protected static ?int $sort = 0;

    protected ?string $pollingInterval = null;

    public function getHeading(): string
    {
        return __('dashboard.stats.heading');
    }

    protected static function appointmentsTrend(): object
    {
        return Appointment::query()
            ->whereBetween('date', self::window())
            ->select(self::comparedBy('date'))
            ->toBase()
            ->first();
    }

    protected static function realizedServicesTrend(): object
    {
        return Intervention::query()
            ->whereBetween('closed_at', self::window())
            ->onlyIndividualServices()
            ->onlyRealized()
            ->select(self::comparedBy('closed_at'))
            ->toBase()
            ->first();
    }

    protected static function allNursesCount(?int $countyId = null): int
    {
        return User::query()
            ->onlyNurses()
            ->when(
                $countyId,
                fn (Builder $query): Builder => $query
                    ->activatesInCounty($countyId)
            )
            ->count();
    }

    protected static function allBeneficiariesCount(): int
    {
        return Beneficiary::query()
            ->count();
    }

    protected static function activeBeneficiariesCount(): int
    {
        return Beneficiary::query()
            ->onlyActive()
            ->count();
    }

    private static function comparedBy(string $column): array
    {
        [$twoMonthsAgo, $oneMonthAgo, $today] = self::boundaries();

        return [
            new Alias(
                new Cast(
                    new Coalesce([
                        new CountFilter(new Between($column, new Value($oneMonthAgo), new Value($today))),
                        new Value(0),
                    ]),
                    'int'
                ),
                'current'
            ),

            new Alias(
                new Cast(
                    new Coalesce([
                        new CountFilter(new Between($column, new Value($twoMonthsAgo), new Value($oneMonthAgo))),
                        new Value(0),
                    ]),
                    'int'
                ),
                'previous'
            ),
        ];
    }

    /**
     * The inclusive date range covered by both comparison periods, used to bound
     * the query so the conditional aggregates only scan the relevant rows.
     */
    private static function window(): array
    {
        [$twoMonthsAgo, , $today] = self::boundaries();

        return [$twoMonthsAgo, $today];
    }

    private static function boundaries(): array
    {
        return [
            today()->subMonths(2)->toDateString(),
            today()->subMonth()->toDateString(),
            today()->toDateString(),
        ];
    }

    protected static function cache(string $key, callable $callback): array
    {
        $ttl = [
            10 * MINUTE_IN_SECONDS,
            48 * HOUR_IN_SECONDS,
        ];

        return Cache::flexible($key, $ttl, $callback);
    }
}
