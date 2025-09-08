<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Pages\Nurse;

use App\Filament\Resources\Users\Pages\Nurse\EditRecord;
use Filament\Schemas\Schema;
use App\Filament\Resources\Profiles\Pages\EditStudies as ProfileEditStudies;

class EditStudies extends EditRecord
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components(ProfileEditStudies::getSchema());
    }
}
