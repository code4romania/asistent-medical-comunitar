<?php

declare(strict_types=1);

namespace App\Reports\Queries\Users;

use App\Enums\User\Status;
use App\Models\User;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;
use Tpetry\QueryExpressions\Language\Alias;
use Tpetry\QueryExpressions\Language\CaseGroup;
use Tpetry\QueryExpressions\Language\CaseRule;
use Tpetry\QueryExpressions\Operator\Comparison\Equal;
use Tpetry\QueryExpressions\Operator\Comparison\NotEqual;
use Tpetry\QueryExpressions\Operator\Logical\CondOr;
use Tpetry\QueryExpressions\Value\Value;

abstract class UserStatusQuery extends ReportQuery
{
    /**
     * Total utilizatori cu status Activ în perioada de referință.
     */
    public static function query(): Builder
    {
        return User::query()
            ->fromSub(
                User::query()
                    ->onlyNurses()
                    ->select([
                        'users.id',
                        'activity_log.created_at',
                        static::userStatus(),
                    ])
                    ->whereHasActivity(function (Builder $query) {
                        $query
                            ->where('log_name', 'default')
                            ->where(function (Builder $query): void {
                                $query
                                    ->whereJsonContainsKey('properties->attributes->deactivated_at')
                                    ->orWhere(function (Builder $query): void {
                                        $query->whereJsonContainsKey('properties->old->password')
                                            ->whereNull('properties->old->password');
                                    });
                            });
                    }),
                'users'
            );
    }

    public static function dateColumn(string $type): string
    {
        return 'created_at';
    }

    private static function userStatus(): Alias
    {
        return new Alias(
            new CaseGroup([
                new CaseRule(
                    new Value(Status::INVITED->value),
                    new Equal(
                        'event',
                        new Value('created')
                    )
                ),

                new CaseRule(
                    new Value(Status::ACTIVE->value),
                    new CondOr(
                        new Equal(
                            'properties->old->password',
                            new Value('null')
                        ),
                        new Equal(
                            'properties->attributes->deactivated_at',
                            new Value('null')
                        )
                    )
                ),

                new CaseRule(
                    new Value(Status::INACTIVE->value),
                    new NotEqual(
                        'properties->attributes->deactivated_at',
                        new Value('null')
                    )
                ),
            ]),
            'status'
        );
    }
}
