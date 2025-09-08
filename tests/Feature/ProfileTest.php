<?php

declare(strict_types=1);

use App\Filament\Resources\Profiles\Pages\ViewGeneral;
use App\Models\User;

beforeEach(function () {
    $this->actingAs(
        User::factory()
            ->nurse()
            ->create()
    );
});

it('can render the general profile page', function () {
    $this->get(ViewGeneral::getUrl())
        ->assertSuccessful();
});
