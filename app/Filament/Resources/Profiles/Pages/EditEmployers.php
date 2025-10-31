<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Pages;

use App\Filament\Resources\Profiles\Schemas\EmployersForm;
use Filament\Schemas\Schema;

class EditEmployers extends EditRecord
{
    public function form(Schema $schema): Schema
    {
        return EmployersForm::configure($schema);
    }
}
