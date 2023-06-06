<?php

declare(strict_types=1);

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CurrentNurseBeneficiaryScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (! auth()->check()) {
            return;
        }

        if (! auth()->user()->isNurse()) {
            return;
        }

        $builder->whereHas('beneficiary', function (Builder $query) {
            $query->whereNurse(auth()->user());
        });
    }
}
