<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages\Nurse;

use App\Filament\Resources\ProfileResource\Schemas\GeneralInfolist;
use Filament\Infolists\Infolist;

class ViewGeneral extends ViewRecord
{
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema(GeneralInfolist::getSchema());
    }

    public function getRelationManagers(): array
    {
        return [];
    }
}
