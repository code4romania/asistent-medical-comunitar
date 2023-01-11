<?php

namespace App\Enums;

use App\Concerns\ArrayableEnum;

enum CourseType: string
{
    use ArrayableEnum;
    case online = 'online';
    case offline = 'offline';

    case other = 'other';
}
