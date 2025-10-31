<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Pages;

use App\Filament\Resources\Profiles\Schemas\StudiesForm;
use Filament\Schemas\Schema;

class EditStudies extends EditRecord
{
    public function form(Schema $schema): Schema
    {
        return StudiesForm::configure($schema);
    }
}
