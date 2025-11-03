<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Pages\Nurse;

use App\Filament\Resources\Profiles\Schemas\EmployersInfolist;
use Filament\Schemas\Schema;

class ViewEmployers extends ViewRecord
{
    public function infolist(Schema $schema): Schema
    {
        return EmployersInfolist::configure($schema);
    }

    protected function beforeFill(): void
    {
        $this->getRecord()->loadMissing([
            'employers.county',
            'employers.city',
        ]);
    }
}
