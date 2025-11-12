<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Pages;

use App\Enums\User\Role;
use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['role'] ??= Role::NURSE;

        if (
            auth()->user()->isCoordinator() &&
            Role::NURSE->is($data['role'])
        ) {
            $data['activity_county_id'] = auth()->user()->county_id;
        }

        return $data;
    }
}
