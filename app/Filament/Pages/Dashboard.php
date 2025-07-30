<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

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

    public function getColumns(): int | string | array
    {
        return 3;
    }
}
