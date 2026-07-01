<?php

declare(strict_types=1);

use App\Enums\Beneficiary\IDType;
use App\Enums\Beneficiary\Type;
use App\Enums\Gender;
use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Beneficiaries\Pages\CreateBeneficiary;
use App\Filament\Resources\Beneficiaries\Pages\ListRegularBeneficiaries;
use App\Models\Beneficiary;
use App\Models\City;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

/**
 * @return array<string, mixed>
 */
function regularBeneficiaryFormData(User $user): array
{
    $city = City::query()
        ->where('county_id', $user->activity_county_id)
        ->firstOrFail();

    return [
        'type' => Type::REGULAR->value,
        'first_name' => 'Ion',
        'last_name' => 'Popescu',
        'does_not_have_cnp' => true,
        'id_type' => IDType::NONE->value,
        'gender' => Gender::MALE->value,
        'county_id' => $user->activity_county_id,
        'city_id' => $city->id,
    ];
}

it('shows a newly created regular beneficiary in the nurse list', function () {
    $nurse = User::factory()->withProfile()->create()->refresh();

    actingAs($nurse);

    livewire(CreateBeneficiary::class)
        ->fillForm(regularBeneficiaryFormData($nurse))
        ->call('create')
        ->assertHasNoFormErrors()
        ->assertRedirect(BeneficiaryResource::getUrl('regular'));

    assertDatabaseHas(Beneficiary::class, [
        'first_name' => 'Ion',
        'last_name' => 'Popescu',
        'nurse_id' => $nurse->id,
    ]);

    $beneficiary = Beneficiary::query()
        ->where('first_name', 'Ion')
        ->where('last_name', 'Popescu')
        ->firstOrFail();

    livewire(ListRegularBeneficiaries::class)
        ->assertCanSeeTableRecords([$beneficiary]);
});

it('shows a newly created regular beneficiary in the mediator list', function () {
    $mediator = User::factory()
        ->mediator()
        ->state([
            'phone' => fake()->phoneNumber(),
            'profile_completed_at' => now(),
            'password_set_at' => now(),
        ])
        ->create()
        ->refresh();

    actingAs($mediator);

    livewire(CreateBeneficiary::class)
        ->fillForm(regularBeneficiaryFormData($mediator))
        ->call('create')
        ->assertHasNoFormErrors()
        ->assertRedirect(BeneficiaryResource::getUrl('regular'));

    assertDatabaseHas(Beneficiary::class, [
        'first_name' => 'Ion',
        'last_name' => 'Popescu',
        'mediator_id' => $mediator->id,
    ]);

    $beneficiary = Beneficiary::query()
        ->where('first_name', 'Ion')
        ->where('last_name', 'Popescu')
        ->firstOrFail();

    livewire(ListRegularBeneficiaries::class)
        ->assertCanSeeTableRecords([$beneficiary]);
});
