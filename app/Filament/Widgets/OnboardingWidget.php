<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class OnboardingWidget extends Widget
{
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    protected static string $view = 'filament.widgets.onboarding-widget';

    public static function canView(): bool
    {
        return auth()->user()->onboarding()->inProgress();
    }
}
