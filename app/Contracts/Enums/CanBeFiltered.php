<?php

declare(strict_types=1);

namespace App\Contracts\Enums;

use App\Enums\Report\Type;
use BackedEnum;

interface CanBeFiltered extends BackedEnum
{
    public function isVisible(?Type $type = null): bool;
}
