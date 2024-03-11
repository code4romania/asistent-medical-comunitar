<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Form;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [];
    }

    public function mount($record): void
    {
        parent::mount($record);

        if ($this->getRecord()->isNurse()) {
            redirect()->to(static::getResource()::getUrl('general.edit', $this->getRecord()));
        }
    }

    protected function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema(CreateUser::getSchema());
    }

    protected function getRedirectUrl(): string
    {
        return UserResource::getUrl('view', $this->getRecord());
    }
}
