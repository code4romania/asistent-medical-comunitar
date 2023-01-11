<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\ArrayableEnum;

enum Gender: string
{
    use ArrayableEnum;

    case female = 'female';
    case male = 'male';
    case other = 'other';
}
