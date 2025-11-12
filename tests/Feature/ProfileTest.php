<?php

declare(strict_types=1);

use App\Filament\Resources\Profiles\Pages\EditArea;
use App\Filament\Resources\Profiles\Pages\EditEmployers;
use App\Filament\Resources\Profiles\Pages\EditGeneral;
use App\Filament\Resources\Profiles\Pages\EditStudies;
use App\Filament\Resources\Profiles\Pages\ViewArea;
use App\Filament\Resources\Profiles\Pages\ViewEmployers;
use App\Filament\Resources\Profiles\Pages\ViewGeneral;
use App\Filament\Resources\Profiles\Pages\ViewStudies;
use App\Models\User;

beforeEach(function () {
    $this->actingAs(
        User::factory()
            ->nurse()
            ->withProfile()
            ->create()
            ->refresh() // required for virtual full_name attribute
    );
});

it('can render the general profile view page', function () {
    $this->get(ViewGeneral::getUrl())
        ->assertSuccessful();
});

it('can render the general profile edit page', function () {
    $this->get(EditGeneral::getUrl())
        ->assertSuccessful();
});

it('can render the studies profile view page', function () {
    $this->get(ViewStudies::getUrl())
        ->assertSuccessful();
});

it('can render the studies profile edit page', function () {
    $this->get(EditStudies::getUrl())
        ->assertSuccessful();
});

it('can render the employers profile view page', function () {
    $this->get(ViewEmployers::getUrl())
        ->assertSuccessful();
});

it('can render the employers profile edit page', function () {
    $this->get(EditEmployers::getUrl())
        ->assertSuccessful();
});

it('can render the areas profile view page', function () {
    $this->get(ViewArea::getUrl())
        ->assertSuccessful();
});

it('can render the areas profile edit page', function () {
    $this->get(EditArea::getUrl())
        ->assertSuccessful();
});
