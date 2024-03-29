<?php

declare(strict_types=1);

namespace App\Enums\Beneficiary;

use App\Concerns;

enum IDType: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasLabel;

    case BIRTH_CERTIFICATE = 'birth_certificate';
    case ID_CARD = 'id_card';
    case NATIONAL_PASSPORT = 'national_passport';
    case FOREIGN_PASSPORT = 'foreign_passport';
    case OTHER = 'other';
    case NONE = 'none';

    protected function labelKeyPrefix(): ?string
    {
        return 'beneficiary.id_type';
    }
}
