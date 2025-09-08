<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Pages\Nurse;

use App\Filament\Resources\Users\Pages\Nurse\ViewRecord;
use Filament\Schemas\Schema;
use App\Filament\Resources\Profiles\Pages\ViewStudies as ProfileViewStudies;

class ViewStudies extends ViewRecord
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components(ProfileViewStudies::getSchema());
    }
}
