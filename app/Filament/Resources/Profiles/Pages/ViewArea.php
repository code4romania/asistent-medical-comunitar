<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Pages;

use Filament\Schemas\Schema;
use App\Filament\Resources\Profiles\Schemas\AreaInfolist;

class ViewArea extends ViewRecord
{
    public function infolist(Schema $schema): Schema
    {
        return $infolist
            ->schema(AreaInfolist::getSchema());
    }

    public function getRelationManagers(): array
    {
        return [];
    }
}
