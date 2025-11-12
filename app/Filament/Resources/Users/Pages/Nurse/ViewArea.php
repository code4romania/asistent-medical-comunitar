<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Pages\Nurse;

use App\Filament\Resources\Profiles\Schemas\AreaInfolist;
use Filament\Schemas\Schema;

class ViewArea extends ViewRecord
{
    public function infolist(Schema $schema): Schema
    {
        return AreaInfolist::configure($schema);
    }
}
