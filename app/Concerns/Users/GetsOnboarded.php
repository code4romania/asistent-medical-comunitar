<?php

declare(strict_types=1);

namespace App\Concerns\Users;

use Spatie\Onboard\Concerns\GetsOnboarded as BaseTrait;

trait GetsOnboarded
{
    use BaseTrait;

    public function initializeGetsOnboarded(): void
    {
        $this->casts['profile_completed_at'] = 'timestamp';
        $this->fillable[] = 'profile_completed_at';
    }

    public function hasCompletedProfile(): bool
    {
        return ! \is_null($this->profile_completed_at);
    }
}
