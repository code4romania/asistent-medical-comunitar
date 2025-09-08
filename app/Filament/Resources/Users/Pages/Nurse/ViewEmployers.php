<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Pages\Nurse;

use Filament\Schemas\Schema;
use App\Filament\Resources\Profiles\Pages\ViewEmployers as ProfileViewEmployers;

class ViewEmployers extends ViewRecord
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components(ProfileViewEmployers::getSchema());
    }

    public function getRelationManagers(): array
    {
        return [];
    }
}
