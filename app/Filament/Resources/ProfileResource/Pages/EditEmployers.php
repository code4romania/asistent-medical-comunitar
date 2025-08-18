<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Filament\Resources\ProfileResource\Schemas\EmployersForm;
use Filament\Forms\Form;

class EditEmployers extends EditRecord
{
    public function form(Form $form): Form
    {
        return $form
            ->schema(EmployersForm::getSchema());
    }
}
