<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Pages;

use Filament\Schemas\Schema;
use App\Filament\Resources\Profiles\Schemas\EmployersInfolist;

class ViewEmployers extends ViewRecord
{
    public function infolist(Schema $schema): Schema
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
