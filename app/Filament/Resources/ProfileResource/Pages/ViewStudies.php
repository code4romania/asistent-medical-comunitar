<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Filament\Resources\ProfileResource\Schemas\StudiesInfolist;
use Filament\Infolists\Infolist;

class ViewStudies extends ViewRecord
{
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema(StudiesInfolist::getSchema());
    }

    protected function beforeFill(): void
    {
        $this->getRecord()->loadMissing([
            'studies.county',
            'studies.city',
        ]);
    }
}
