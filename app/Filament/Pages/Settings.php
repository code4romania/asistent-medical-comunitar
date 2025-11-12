<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use Illuminate\Contracts\Support\Htmlable;
use Jeffgreco13\FilamentBreezy\Pages\MyProfilePage;

class Settings extends MyProfilePage
{
    public function getTitle(): string
    {
        return __('auth.settings');
    }

    public function getHeading(): string|Htmlable
    {
        return $this->getTitle();
    }

    public function getSubheading(): string|Htmlable|null
    {
        return null;
    }
}
