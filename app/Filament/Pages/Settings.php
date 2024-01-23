<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Filament\Forms\Components\Value;
use Filament\Forms\Components\TextInput;
use JeffGreco13\FilamentBreezy\Pages\MyProfile;

class Settings extends MyProfile
{
    protected static ?string $slug = 'settings';

    protected function getTitle(): string
    {
        return __('auth.settings');
    }

    protected function getBreadcrumbs(): array
    {
        return [
            //
        ];
    }

    protected function getUpdateProfileFormSchema(): array
    {
        return [
            Value::make('username')
                ->label(__('field.username')),

            TextInput::make('email')
                ->required()
                ->email()
                ->unique(config('filament-breezy.user_model'), ignoreRecord: true)
                ->label(__('filament-breezy::default.fields.email')),
        ];
    }
}
