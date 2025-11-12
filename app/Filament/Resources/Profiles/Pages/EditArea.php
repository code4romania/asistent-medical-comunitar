<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Pages;

use App\Filament\Resources\Profiles\Schemas\AreaForm;
use Filament\Schemas\Schema;

class EditArea extends EditRecord
{
    public function form(Schema $schema): Schema
    {
        return AreaForm::configure($schema);
    }
}
