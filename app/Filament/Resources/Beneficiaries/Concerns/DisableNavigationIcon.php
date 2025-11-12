<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Concerns;

use BackedEnum;
use Illuminate\Contracts\Support\Htmlable;

trait DisableNavigationIcon
{
    public static function getNavigationIcon(): string | BackedEnum | Htmlable | null
    {
        return null;
    }
}
