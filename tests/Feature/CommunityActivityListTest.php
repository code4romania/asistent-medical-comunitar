<?php

declare(strict_types=1);

use App\Enums\CommunityActivity\Campaign;
use App\Filament\Resources\CommunityActivities\Pages\ManageCampaigns;
use App\Models\CommunityActivity;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

it('shows the creating mediator name to the allocated nurse in the campaigns list', function () {
    $nurse = User::factory()->withProfile()->create()->refresh();

    $mediator = User::factory()
        ->mediator()
        ->state([
            'activity_county_id' => $nurse->activity_county_id,
            'phone' => fake()->phoneNumber(),
            'profile_completed_at' => now(),
            'password_set_at' => now(),
        ])
        ->create()
        ->refresh();

    actingAs($mediator);

    livewire(ManageCampaigns::class)
        ->callAction('create_campaign', [
            'subtype' => Campaign::LOCAL->value,
            'nurse_id' => $nurse->id,
            'name' => 'Campanie test',
            'organizer' => 'Organizator test',
            'location' => 'Locatie test',
            'date' => today()->toDateString(),
            'participants' => 10,
            'outside_working_hours' => false,
        ])
        ->assertNotified();

    assertDatabaseHas(CommunityActivity::class, [
        'name' => 'Campanie test',
        'nurse_id' => $nurse->id,
        'mediator_id' => $mediator->id,
    ]);

    $activity = CommunityActivity::query()
        ->where('name', 'Campanie test')
        ->firstOrFail();

    actingAs($nurse->refresh());

    livewire(ManageCampaigns::class)
        ->assertCanSeeTableRecords([$activity])
        ->assertSee($mediator->full_name);
});
