<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Pages\Auth\Login;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }

    /** @test */
    public function it_can_render_the_login_screen(): void
    {
        $this->get(route('filament.auth.login'))
            ->assertOk();
    }

    /** @test */
    public function users_can_authenticate_using_the_login_screen(): void
    {
        $this->assertGuest();

        $user = User::factory()
            ->nurse()
            ->create();

        Livewire::test(Login::class)
            ->fillForm([
                'email' => $user->email,
                'password' => 'password',
            ])
            ->call('authenticate')
            ->assertRedirect(route('filament.pages.dashboard'));

        $this->assertAuthenticatedAs($user);
    }
}
