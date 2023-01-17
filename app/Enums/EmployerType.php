<?php

declare(strict_types=1);

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

    protected function translationKeyPrefix(): ?string
    {
        return 'user.profile.employer';
    }
}
