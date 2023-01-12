<?php

namespace App\Enums;

use App\Concerns\ArrayableEnum;

enum EmployerType: string
{
    use ArrayableEnum;
    case ong = 'ong';
    case dsp = 'dsp';
    case gp = 'gp';
    case cityHall = 'city_hall';

    case other = 'other';
}
