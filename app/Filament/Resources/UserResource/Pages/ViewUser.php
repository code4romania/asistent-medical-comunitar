<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    public function mount($record): void
    {
        static::authorizeResourceAccess();

        $this->record = $this->resolveRecord($record);

        abort_unless(static::getResource()::canView($this->getRecord()), 403);

        $url = match (true) {
            $this->record->isNurse() => static::getResource()::getUrl('general.view', $this->record),
            $this->record->isAdmin() => static::getResource()::getUrl('general.view', $this->record),
            $this->record->isCoordinator() => static::getResource()::getUrl('general.view', $this->record),
        };

        redirect()->to($url);
    }
}
