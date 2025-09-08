<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Pages;

use App\Filament\Resources\Profiles\Pages\ViewRecord;
use Filament\Schemas\Schema;
use App\Filament\Resources\Profiles\Schemas\StudiesInfolist;

class ViewStudies extends ViewRecord
{
    public function infolist(Schema $schema): Schema
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
