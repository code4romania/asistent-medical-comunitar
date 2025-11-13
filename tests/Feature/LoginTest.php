<?php

declare(strict_types=1);

use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Dashboard;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Support\Str;
use function Pest\Livewire\livewire;

it('can render the login page', function () {
    $this->get(Filament::getLoginUrl())
        ->assertSuccessful();
});

it('can authenticate active users', function () {
    $user = User::factory()
        ->nurse()
        ->create();

    livewire(Login::class)
        ->fillForm([
            'email' => $user->email,
            'password' => 'password',
        ])
        ->call('authenticate')
        ->assertSuccessful()
        ->assertRedirect(Dashboard::getUrl());
});

it('can authenticate and redirect user to their intended URL', function () {
    session()->put('url.intended', $intendedUrl = Str::random());

    $user = User::factory()
        ->nurse()
        ->create();

    livewire(Login::class)
        ->fillForm([
            'email' => $user->email,
            'password' => 'password',
        ])
        ->call('authenticate')
        ->assertRedirect($intendedUrl);
});

it('can redirect unauthenticated app requests', function () {
    $this->get(Dashboard::getUrl())
        ->assertRedirect(Filament::getLoginUrl());
});

it('cannot authenticate with incorrect credentials', function () {
    $user = User::factory()
        ->nurse()
        ->create();

    livewire(Login::class)
        ->fillForm([
            'email' => $user->email,
            'password' => 'incorrect-password',
        ])
        ->call('authenticate')
        ->assertHasFormErrors(['email']);

    $this->assertGuest();
});

it('can throttle authentication attempts', function () {
    $this->assertGuest();

    $user = User::factory()
        ->nurse()
        ->create();

    collect()
        ->range(1, 5)
        ->each(function () use ($user) {
            livewire(Login::class)
                ->fillForm([
                    'email' => $user->email,
                    'password' => 'password',
                ])
                ->call('authenticate');

            $this->assertAuthenticated();

            auth()->logout();
        });

    livewire(Login::class)
        ->fillForm([
            'email' => $user->email,
            'password' => 'password',
        ])
        ->call('authenticate')
        ->assertNotified();

    $this->assertGuest();
});

it('can validate `email` is required', function () {
    livewire(Login::class)
        ->fillForm(['email' => ''])
        ->call('authenticate')
        ->assertHasFormErrors(['email' => ['required']]);
});

it('can validate `email` is valid email', function () {
    livewire(Login::class)
        ->fillForm(['email' => 'invalid-email'])
        ->call('authenticate')
        ->assertHasFormErrors(['email' => ['email']]);
});

it('can validate `password` is required', function () {
    livewire(Login::class)
        ->fillForm(['password' => ''])
        ->call('authenticate')
        ->assertHasFormErrors(['password' => ['required']]);
});
