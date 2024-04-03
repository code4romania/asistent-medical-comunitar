<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\User;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use JeffGreco13\FilamentBreezy\FilamentBreezy;
use Livewire\Component;

class Welcome extends Component implements HasForms
{
    use InteractsWithForms;
    use WithRateLimiting;

    public ?User $user = null;

    public ?string $email = null;

    public ?string $password = null;

    public ?string $passwordConfirmation = null;

    public function mount($user, Request $request): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        if (! $request->hasValidSignature()) {
            abort(Response::HTTP_FORBIDDEN, __('welcome.invalid_signature'));
        }

        $this->user = $user;

        if (\is_null($this->user)) {
            abort(Response::HTTP_FORBIDDEN, __('welcome.no_user'));
        }

        $this->form->fill([
            'email' => $this->user?->email,
        ]);
    }

    public function handle(): void
    {
        $this->user->update([
            'password' => Hash::make(data_get($this->form->getState(), 'password')),
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('email')
                ->label(__('filament::login.fields.email.label'))
                ->email()
                ->maxLength(200)
                ->disabled(),

            TextInput::make('password')
                ->label(__('filament::login.fields.password.label'))
                ->password()
                ->rules(app(FilamentBreezy::class)->getPasswordRules())
                ->required()
                ->confirmed(),

            TextInput::make('password_confirmation')
                ->label(__('filament::login.fields.password.label'))
                ->password()
                ->required(),
        ];
    }

    public function render(): View
    {
        return view('auth.welcome')
            ->layout('components.layouts.onboarding', [
                'title' => __('filament::login.title'),
            ]);
    }
}
