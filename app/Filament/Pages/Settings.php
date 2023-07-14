<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use Filament\Forms\Components\TextInput;
use JeffGreco13\FilamentBreezy\Pages\MyProfile;

class Settings extends MyProfile
{
    protected static ?string $slug = 'settings';

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
