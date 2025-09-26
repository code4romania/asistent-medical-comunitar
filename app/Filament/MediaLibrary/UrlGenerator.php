<?php

declare(strict_types=1);

namespace App\Filament\MediaLibrary;

use Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator;

class UrlGenerator extends DefaultUrlGenerator
{
    public function getUrl(): string
    {
        return $this->versionUrl(route('filament.media', $this->media));
    }
}
