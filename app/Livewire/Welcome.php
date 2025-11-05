<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\User;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\SimplePage;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules\Password;

class Welcome extends SimplePage
{
    use WithRateLimiting;

    protected string $view = 'auth.welcome';

    protected static string $layout = 'components.layouts.minimal';

    public ?User $user = null;

    public ?array $data = [];

    public function mount(Request $request, ?User $user): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        abort_unless($request->hasValidSignature(), Response::HTTP_FORBIDDEN, __('welcome.invalid_signature'));

        abort_unless(filled($user), Response::HTTP_FORBIDDEN, __('welcome.no_user'));

        $this->user = $user;

        $this->form->fill();
    }

    public function getTitle(): string
    {
        if ($this->user->hasSetPassword()) {
            return __('welcome.onboarding.heading');
        }

        return __('welcome.set_password.submit');
    }

    public function getHeading(): string
    {
        return  __('welcome.set_password.greeting', [
            'name' => $this->user->first_name,
        ]);
    }

    public function getSubheading(): string
    {
        return __('welcome.set_password.intro');
    }

    public function handle(): void
    {
        $this->user->update([
            'password' => data_get($this->form->getState(), 'password'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('email')
                    ->label(__('filament-panels::auth/pages/password-reset/reset-password.form.email.label'))
                    ->default($this->user->email),

                TextInput::make('password')
                    ->label(__('filament-panels::auth/pages/password-reset/reset-password.form.password.label'))
                    ->password()
                    ->rule(Password::default())
                    ->required()
                    ->confirmed(),

                TextInput::make('password_confirmation')
                    ->label(__('filament-panels::auth/pages/password-reset/reset-password.form.password_confirmation.label'))
                    ->password()
                    ->required(),
            ])
            ->statePath('data');
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([EmbeddedSchema::make('form')])
                    ->id('form')
                    ->livewireSubmitHandler('handle')
                    ->footer([
                        Actions::make([
                            Action::make('submit')
                                ->label(__('welcome.set_password.submit'))
                                ->submit('form'),
                        ])->fullWidth(),
                    ]),
            ]);
    }

    protected function getLayoutData(): array
    {
        return [
            'title' => $this->getTitle(),
        ];
    }
}
