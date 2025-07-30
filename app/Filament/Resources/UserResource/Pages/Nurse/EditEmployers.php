<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages\Nurse;

use App\Filament\Resources\ProfileResource\Pages\EditEmployers as ProfileEditEmployers;
use Filament\Forms\Form;

class EditEmployers extends EditRecord
{
    public function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema(ProfileEditEmployers::getSchema());
    }
}
