<?php

declare(strict_types=1);

namespace App\Filament\Pages\Auth;

use JeffGreco13\FilamentBreezy\Http\Livewire\Auth\Login as BaseLogin;

class Login extends BaseLogin
{
    public function mount(): void
    {
        parent::mount();

        if (! app()->isLocal()) {
            return;
        }

        $this->loginAsNurse();
    }

    private function loginAsNurse(): void
    {
        $this->form->fill([
            'email' => 'nurse@example.com',
            'password' => 'password',
            'remember' => true,
        ]);
    }
}
