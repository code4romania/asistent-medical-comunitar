<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Filament\Resources\ProfileResource\Schemas\EmployersInfolist;
use Filament\Infolists\Infolist;

class ViewEmployers extends ViewRecord
{
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema(EmployersInfolist::getSchema());
    }

    public function getRelationManagers(): array
    {
        return [];
    }

    protected function beforeFill(): void
    {
        $this->getRecord()->loadMissing([
            'employers.county',
            'employers.city',
        ]);
    }
}
