<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Concerns\ResolvesCurrentUserProfile;
use App\Filament\Resources\ProfileResource;
use Filament\Forms\Components\Placeholder;
use Filament\Pages\Actions;
use Filament\Resources\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewArea extends ViewRecord
{
    use ResolvesCurrentUserProfile;

    protected static string $resource = ProfileResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    protected function form(Form $form): Form
    {
        return $form
            ->schema([
                Placeholder::make('data.text')->content('aaaaaa'),
                Placeholder::make('data.text')->content('aaaaaa'),
            ]);
    }
}
