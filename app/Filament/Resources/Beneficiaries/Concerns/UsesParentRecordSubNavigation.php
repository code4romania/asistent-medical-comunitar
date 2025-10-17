<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Concerns;

trait UsesParentRecordSubNavigation
{
    public function getSubNavigationParameters(): array
    {
        return [
            'record' => $this->getParentRecord() ?? $this->getRecord(),
        ];
    }
}
