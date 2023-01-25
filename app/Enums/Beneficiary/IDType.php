<?php

declare(strict_types=1);

namespace App\Enums\Beneficiary;

use App\Concerns\ArrayableEnum;

enum IDType: string
{
    use ArrayableEnum;

    case birth_certificate = 'birth_certificate';
    case id_card = 'id_card';
    case local_passport = 'local_passport';
    case foreign_passport = 'foreign_passport';
    case other = 'other';
    case none = 'none';

    protected function translationKeyPrefix(): ?string
    {
        return 'beneficiary.id_type';
    }
}
