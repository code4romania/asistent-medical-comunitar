<?php

declare(strict_types=1);

namespace App\Filament\Pages\Settings;

use Jeffgreco13\FilamentBreezy\Livewire\PersonalInfo as BasePersonalInfo;

class PersonalInfo extends BasePersonalInfo
{
    public array $only = ['email'];

    protected function getProfileFormComponents(): array
    {
        return [
            $this->getEmailComponent(),
        ];
    }
}
