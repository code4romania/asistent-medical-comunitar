<?php

declare(strict_types=1);

namespace App\Contracts\Pages;

interface WithSidebar
{
    public function getSidebarNavigation(): array;
}
