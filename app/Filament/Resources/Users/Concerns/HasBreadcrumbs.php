<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Concerns;

use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ViewUser;
use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Resources\Pages\ListRecords;

trait HasBreadcrumbs
{
    public function getBreadcrumbs(): array
    {
        // No breadcrumbs for the list page
        if ($this instanceof ListRecords) {
            return [];
        }

        /** @var User */
        $user = $this->getRecord();

        $breadcrumbs = [
            UserResource::getUrl('index') => UserResource::getBreadcrumb(),
        ];

        if (
            ! $this instanceof ViewUser &&
            ! $this instanceof EditUser &&
            $user?->exists
        ) {
            $breadcrumbs[
                UserResource::getUrl('view', ['record' => $user])
            ] = UserResource::getRecordTitle($user);
        }

        $breadcrumbs[] = $this->getBreadcrumb();

        return $breadcrumbs;
    }
}
