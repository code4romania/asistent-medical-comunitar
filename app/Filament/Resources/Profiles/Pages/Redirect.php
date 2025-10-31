<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Pages;

use App\Filament\Resources\Profiles\Concerns\ResolvesRecord;
use App\Filament\Resources\Profiles\ProfileResource;
use Filament\Resources\Pages\ViewRecord;

class Redirect extends ViewRecord
{
    use ResolvesRecord;

    protected static string $resource = ProfileResource::class;

    protected function beforeFill(): void
    {
        redirect()->to(ProfileResource::getUrl('general.view'));
    }
}
