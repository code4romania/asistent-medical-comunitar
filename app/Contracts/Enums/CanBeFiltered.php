<?php

declare(strict_types=1);

namespace App\Contracts\Enums;

use BackedEnum;

interface CanBeFiltered extends BackedEnum
{
    public function isVisible(): bool;
}
