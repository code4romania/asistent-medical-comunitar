<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Pages\Nurse;

use App\Filament\Resources\Profiles\Schemas\StudiesInfolist;
use Filament\Schemas\Schema;

class ViewStudies extends ViewRecord
{
    public function infolist(Schema $schema): Schema
    {
        return StudiesInfolist::configure($schema);
    }

    protected function beforeFill(): void
    {
        $this->getRecord()->loadMissing([
            'studies.county',
            'studies.city',
        ]);
    }
}
