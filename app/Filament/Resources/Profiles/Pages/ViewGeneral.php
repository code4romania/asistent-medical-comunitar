<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Pages;

use App\Filament\Resources\Profiles\Schemas\GeneralInfolist;
use Filament\Schemas\Schema;

class ViewGeneral extends ViewRecord
{
    public function infolist(Schema $schema): Schema
    {
        return GeneralInfolist::configure($schema);
    }

    public function getRelationManagers(): array
    {
        return [];
    }
}
