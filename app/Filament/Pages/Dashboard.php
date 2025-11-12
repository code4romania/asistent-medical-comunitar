<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends BaseDashboard
{
    public function getHeading(): string
    {
        return __('dashboard.welcome', [
            'name' => auth()->user()->first_name,
        ]);
    }

    public static function getNavigationLabel(): string
    {
        return __('dashboard.home');
    }

    public static function getNavigationIcon(): string | BackedEnum | Htmlable | null
    {
        return null;
    }

    public function getColumns(): int|array
    {
        return 3;
    }
}
