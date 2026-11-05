<?php

declare(strict_types=1);

namespace App\Contracts\Enums;

use BackedEnum;

interface HasQuery extends BackedEnum
{
    public function class(): string;
}
