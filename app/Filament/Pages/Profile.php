<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Illuminate\Support\Str;

abstract class Profile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.pages.profile';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $slug = 'account/profile';

    protected static bool $isEditing = false;

    protected function getTitle(): string
    {
        return __('user.profile.my_profile');
    }

    protected function getSections(): array
    {
        return [
            'general'   => __('user.profile.general'),
            'studies'   => __('user.profile.studies'),
            'employers' => __('user.profile.employers'),
            'area'      => __('user.profile.area'),
        ];
    }

    public function getActiveSection(): ?string
    {
        return (string) Str::of(class_basename(static::class))
            ->kebab()
            ->replace('-', ' ');
    }

    public static function getSlug(): string
    {
        if (self::class === static::class) {
            return parent::getSlug();
        }

        return self::$slug . '/' . Str::of(static::class)
            ->classBasename()
            ->kebab()
            ->slug();
    }
}
