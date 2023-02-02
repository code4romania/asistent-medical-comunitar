<?php

declare(strict_types=1);

namespace App\Enums\Beneficiary;

use App\Concerns\ArrayableEnum;

enum IDType: string
{
    use ArrayableEnum;

    case BIRTH_CERTIFICATE = 'birth_certificate';
    case ID_CARD = 'id_card';
    case NATIONAL_PASSPORT = 'national_passport';
    case FOREIGN_PASSPORT = 'foreign_passport';
    case OTHER = 'other';
    case NONE = 'none';

    protected function translationKeyPrefix(): ?string
    {
        return 'beneficiary.id_type';
    }
}
