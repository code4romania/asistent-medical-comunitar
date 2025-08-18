<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Filament\Resources\ProfileResource\Schemas\AreaForm;
use Filament\Forms\Form;

class EditArea extends EditRecord
{
    public function form(Form $form): Form
    {
        return $form
            ->schema(AreaForm::getSchema());
    }
}
