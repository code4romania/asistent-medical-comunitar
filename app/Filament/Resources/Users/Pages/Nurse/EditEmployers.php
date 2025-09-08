<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Pages\Nurse;

use Filament\Schemas\Schema;
use App\Filament\Resources\Profiles\Pages\EditEmployers as ProfileEditEmployers;

class EditEmployers extends EditRecord
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components(ProfileEditEmployers::getSchema());
    }
}
