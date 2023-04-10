<?php

declare(strict_types=1);

namespace App\Providers;

use App\Filament\Resources\ProfileResource;
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
        tap($this->app->isLocal(), function (bool $shouldBeEnabled) {
            Model::preventLazyLoading($shouldBeEnabled);
            Model::preventAccessingMissingAttributes($shouldBeEnabled);
        });

        Filament::serving(function () {
            Filament::registerViteTheme('resources/css/app.css');

            $this->registerUserMenuItems();
        });
    }

    protected function registerUserMenuItems(): void
    {
        if (auth()->guest()) {
            return;
        }

        if (auth()->user()->isNurse()) {
            $items = [
                'account' => UserMenuItem::make()
                    ->url(ProfileResource::getUrl('general.view')),
            ];
        } else {
            $items = [
                //
            ];
        }

        Filament::registerUserMenuItems($items);
    }
}
