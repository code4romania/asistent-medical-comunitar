<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Pages\Nurse;

use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\Users\Concerns\HasTabs;
use App\Filament\Resources\Users\UserResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord as BaseEditRecord;
use Filament\Support\Icons\Heroicon;

abstract class EditRecord extends BaseEditRecord implements WithTabs
{
    use HasTabs;

    protected static string $resource = UserResource::class;

    protected function authorizeAccess(): void
    {
        parent::authorizeAccess();

        abort_unless($this->getRecord()->isNurse(), 403);
    }

    public function getTitle(): string
    {
        return $this->getRecord()->full_name;
    }

    public function getBreadcrumbs(): array
    {
        return [
            auth()->user()->getFilamentName(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getPageUrl("{$this->getActiveTab()}.view");
    }

    protected function getSaveFormAction(): Action
    {
        return parent::getSaveFormAction()
            ->icon(Heroicon::OutlinedCheck);
    }
}
