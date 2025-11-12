<?php

declare(strict_types=1);

namespace App\Enums\Beneficiary;

use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum IDType: string implements HasLabel
{
    use Arrayable;
    use Comparable;

    case BIRTH_CERTIFICATE = 'birth_certificate';
    case ID_CARD = 'id_card';
    case NATIONAL_PASSPORT = 'national_passport';
    case FOREIGN_PASSPORT = 'foreign_passport';
    case OTHER = 'other';
    case NONE = 'none';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::BIRTH_CERTIFICATE => __('beneficiary.id_type.birth_certificate'),
            self::ID_CARD => __('beneficiary.id_type.id_card'),
            self::NATIONAL_PASSPORT => __('beneficiary.id_type.national_passport'),
            self::FOREIGN_PASSPORT => __('beneficiary.id_type.foreign_passport'),
            self::OTHER => __('beneficiary.id_type.other'),
            self::NONE => __('beneficiary.id_type.none'),
        };
    }
}
