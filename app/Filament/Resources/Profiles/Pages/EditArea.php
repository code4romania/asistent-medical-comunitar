<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Pages;

use Filament\Schemas\Schema;
use App\Filament\Resources\Profiles\Schemas\AreaForm;

class EditArea extends EditRecord
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components(AreaForm::getSchema());
    }
}
