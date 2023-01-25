<?php

declare(strict_types=1);

namespace App\Contracts\Pages;

interface WithTabs
{
    public function getTabs(): array;

    public function getActiveTab(): string;
}
