<?php

declare(strict_types=1);

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class BeneficiaryScope implements Scope
{
    public function apply(Builder $query, Model $model): void
    {
        if (! auth()->check()) {
            return;
        }

        if (! auth()->user()->isNurse()) {
            return;
        }

        $query->whereNurse(auth()->user());
    }
}
