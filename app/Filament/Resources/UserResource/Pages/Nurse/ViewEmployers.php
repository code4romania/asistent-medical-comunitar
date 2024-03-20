<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages\Nurse;

use App\Filament\Resources\ProfileResource\Pages\ViewEmployers as ProfileViewEmployers;
use Filament\Resources\Form;

class ViewEmployers extends ViewRecord
{
    protected function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema(ProfileViewEmployers::getSchema());
    }

    protected function getRelationManagers(): array
    {
        return [];
    }
}
