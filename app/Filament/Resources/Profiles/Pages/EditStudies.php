<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Pages;

use App\Filament\Resources\Profiles\Pages\EditRecord;
use Filament\Schemas\Schema;
use App\Filament\Resources\Profiles\Schemas\StudiesForm;

class EditStudies extends EditRecord
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components(StudiesForm::getSchema());
    }
}
