<?php

declare(strict_types=1);

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::shouldBeStrict($this->app->isLocal());

        Filament::serving(function () {
            Filament::registerViteTheme('resources/css/app.css');

            Filament::registerUserMenuItems([
                'account' => UserMenuItem::make()
                    ->url(route('filament.resources.profile.general.view')),
            ]);
        });
    }
}
