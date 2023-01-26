<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected function getHeading(): string
    {
        return __('dashboard.welcome', [
            'name' => auth()->user()->first_name,
        ]);
    }

    protected static function getNavigationLabel(): string
    {
        return __('dashboard.home');
    }
}
