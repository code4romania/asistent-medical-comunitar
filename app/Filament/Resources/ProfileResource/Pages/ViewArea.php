<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Filament\Resources\ProfileResource\Schemas\AreaInfolist;
use Filament\Infolists\Infolist;

class ViewArea extends ViewRecord
{
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema(AreaInfolist::getSchema());
    }

    public function getRelationManagers(): array
    {
        return [];
    }
}
