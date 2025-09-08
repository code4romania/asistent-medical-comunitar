<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Filament\Resources\Users\Pages\CreateUser;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function mount(int | string $record): void
    {
        parent::mount($record);

        if ($this->getRecord()->isNurse()) {
            redirect()->to(static::getResource()::getUrl('general.edit', $this->getRecord()));
        }
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components(CreateUser::getFormSchema());
    }

    protected function getRedirectUrl(): string
    {
        return UserResource::getUrl('view', [
            'record' => $this->getRecord(),
        ]);
    }
}
