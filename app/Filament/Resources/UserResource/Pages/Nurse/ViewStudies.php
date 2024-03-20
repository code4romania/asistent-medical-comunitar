<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages\Nurse;

use App\Filament\Resources\ProfileResource\Pages\ViewStudies as ProfileViewStudies;
use Filament\Resources\Form;

class ViewStudies extends ViewRecord
{
    protected function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema(ProfileViewStudies::getSchema());
    }
}
