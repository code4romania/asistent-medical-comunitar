<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::domain(config('filament.domain'))
    ->name('filament.')
    ->group(function () {
        Route::prefix(config('filament.path'))->group(function () {
            Route::get('/welcome/{user}', \App\Http\Livewire\Welcome::class)->name('auth.welcome');
        });
    });
