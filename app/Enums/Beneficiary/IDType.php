<?php

declare(strict_types=1);

namespace App\Enums\Beneficiary;

use App\Concerns;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;

enum IDType: string
{
    use Arrayable;
    use Comparable;
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
