<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/welcome/{user:uuid}', App\Http\Livewire\Welcome::class)->name('auth.welcome');

Route::get('/media/{media:uuid}', App\Http\Controllers\MediaController::class)
    ->middleware(config('filament.middleware.auth'))
    ->name('media');
