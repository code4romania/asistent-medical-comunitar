<?php

declare(strict_types=1);

namespace App\Contracts\Enums;

use App\Enums\Report\Type;
use BackedEnum;

interface HasTypes extends BackedEnum
{
    /**
     * @return array<Type>
     */
    public static function types(): array;
}
