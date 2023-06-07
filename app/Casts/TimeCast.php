<?php

declare(strict_types=1);

namespace App\Casts;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class TimeCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        return rescue(
            fn () => Carbon::createFromFormat('H:i:s', $value)->format('H:i'),
            report: false
        );
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if ($value instanceof Carbon) {
            return $value
                ->setSeconds(0)
                ->format('H:i:s');
        }

        return $value;
    }
}
