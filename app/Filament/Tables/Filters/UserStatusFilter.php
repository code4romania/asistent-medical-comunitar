<?php

declare(strict_types=1);

namespace App\Filament\Tables\Filters;

use App\Enums\User\Status;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class UserStatusFilter extends SelectFilter
{
    public static function getDefaultName(): ?string
    {
        return 'status';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('field.status'));

        $this->options(Status::class);

        $this->query(function (Builder $query, array $data) {
            $status = Status::tryFrom((string) data_get($data, 'value'));

            return match ($status) {
                Status::ACTIVE => $query->onlyActive(),
                Status::INACTIVE => $query->onlyInactive(),
                Status::INVITED => $query->onlyInvited(),
                default => $query,
            };
        });
    }
}
