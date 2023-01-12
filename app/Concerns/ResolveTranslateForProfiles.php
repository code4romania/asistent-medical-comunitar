<?php

namespace App\Concerns;

use App\Filament\Resources\ProfileResource\Pages\ViewStudies;

trait ResolveTranslateForProfiles
{
    public function getTranslationLabel(string $key): string
    {
        $class = get_class($this);
        $view = last(explode("\\", $class));
        $keyPath = match ($view) {
            'ViewStudies' => 'user.profile.studies_page.',
            'ViewGeneral' => 'user.profile.general_page.',
            'ViewEmployers' => 'user.profile.employers_page.',
            'ViewArea' => 'user.profile.area_page.',
        };
        return __($keyPath . $key);
    }
}
