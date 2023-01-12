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
            'ViewStudies', 'EditStudies' => 'user.profile.studies_page.',
            'ViewGeneral', 'EditGeneral' => 'user.profile.general_page.',
            'ViewEmployers', 'EditEmployers' => 'user.profile.employers_page.',
            'ViewArea', 'EditArea' => 'user.profile.area_page.',
        };
        return __($keyPath . $key);
    }
}
