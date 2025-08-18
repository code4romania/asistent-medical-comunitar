<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Filament\Resources\ProfileResource\Schemas\StudiesForm;
use Filament\Forms\Form;

class EditStudies extends EditRecord
{
    public function form(Form $form): Form
    {
        return $form
            ->schema(StudiesForm::getSchema());
    }
}
