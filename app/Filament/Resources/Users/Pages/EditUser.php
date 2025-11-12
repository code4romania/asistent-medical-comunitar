<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function authorizeAccess(): void
    {
        parent::authorizeAccess();

        if ($this->getRecord()->isNurse()) {
            redirect()->to(UserResource::getUrl('general.edit', [
                'record' => $this->getRecord(),
            ]));
        }
    }
}
