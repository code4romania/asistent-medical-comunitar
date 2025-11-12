<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Pages\Nurse;

use App\Filament\Resources\Profiles\Schemas\GeneralInfolist;
use Filament\Schemas\Schema;

class ViewGeneral extends ViewRecord
{
    public function infolist(Schema $schema): Schema
    {
        return GeneralInfolist::configure($schema);
    }
}
