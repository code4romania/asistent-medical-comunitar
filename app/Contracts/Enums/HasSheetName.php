<?php

declare(strict_types=1);

namespace App\Contracts\Enums;

use BackedEnum;
use Illuminate\Contracts\Support\Htmlable;

interface HasSheetName extends BackedEnum
{
    public function getSheetName(): string | Htmlable | null;
}
