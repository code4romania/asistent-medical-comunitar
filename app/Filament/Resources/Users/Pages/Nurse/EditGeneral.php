<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Pages\Nurse;

use App\Filament\Resources\Profiles\Schemas\GeneralForm;
use Filament\Schemas\Schema;

class EditGeneral extends EditRecord
{
    public function form(Schema $schema): Schema
    {
        return GeneralForm::configure($schema);
    }
}
