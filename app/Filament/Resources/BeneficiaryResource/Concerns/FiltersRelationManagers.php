<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Concerns;

trait FiltersRelationManagers
{
    protected function getRelationManagers(): array
    {
        $managers = parent::getRelationManagers();

        $allowedManager = $this->getAllowedRelationManager();

        if (empty($allowedManager)) {
            return $managers;
        }

        return array_filter(
            $managers,
            fn (string $manager) => $manager === $allowedManager
        );
    }

    protected function getAllowedRelationManager(): string
    {
        return '';
    }
}
