<?php

declare(strict_types=1);

namespace App\Contracts\Enums;

use App\Enums\Report\Type;
use App\Enums\User\Role;
use BackedEnum;

interface HasColumns extends BackedEnum
{
    /**
     * @return array<string>
     */
    public static function columns(Type $type, Role $role): array;
}
