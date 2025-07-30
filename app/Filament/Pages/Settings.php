<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use Filament\Forms\Components\TextInput;
use Jeffgreco13\FilamentBreezy\Pages\MyProfilePage;

class Settings extends MyProfilePage
{
    protected static ?string $slug = 'settings';

    protected static bool $isDiscovered = false;

    public function getTitle(): string
    {
        return __('auth.settings');
    }

    // public function getBreadcrumbs(): array
    // {
    //     return [
    //         //
    //     ];
    // }

    protected function getUpdateProfileFormSchema(): array
    {
        return [
            TextInput::make($this->loginColumn)
                ->required()
                ->email(fn () => $this->loginColumn === 'email')
                ->unique(config('filament-breezy.user_model'), ignorable: $this->user)
                ->label(__('filament-breezy::default.fields.email')),
        ];
    }
}
