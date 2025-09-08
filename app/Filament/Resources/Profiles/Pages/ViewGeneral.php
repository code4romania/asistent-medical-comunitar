<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Pages;

use Filament\Schemas\Schema;
use App\Filament\Resources\Profiles\Schemas\GeneralInfolist;

class ViewGeneral extends ViewRecord
{
    public function infolist(Schema $schema): Schema
    {
        return $infolist
            ->schema(GeneralInfolist::getSchema());
    }

    public function getRelationManagers(): array
    {
        return [];
    }
}
