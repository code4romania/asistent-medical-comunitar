<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages\Nurse;

use App\Filament\Resources\ProfileResource\Pages\EditStudies as ProfileEditStudies;
use Filament\Resources\Form;

class EditStudies extends EditRecord
{
    protected function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema(ProfileEditStudies::getSchema());
    }
}
