<?php

declare(strict_types=1);

namespace App\Contracts\Pages;

/**
 * @deprecated Use \Filament\Pages\Concerns\HasSubNavigation instead.
 */
interface WithSidebar
{
    public function getSidebarNavigation(): array;
}
