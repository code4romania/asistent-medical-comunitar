<?php

declare(strict_types=1);

namespace App\Enums\Report\Standard\Indicators;

use App\Concerns;

enum Child: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasLabel;

    case C01 = 'C01';
    case C02 = 'C02';
    case C03 = 'C03';
    case C04 = 'C04';
    case C05 = 'C05';
    case C06 = 'C06';
    case C07 = 'C07';
    case C08 = 'C08';
    case C09 = 'C09';
    case C10 = 'C10';
    case C11 = 'C11';
    case C12 = 'C12';
    case C13 = 'C13';
    case C14 = 'C14';
    case C15 = 'C15';
    case C16 = 'C16';
    case C17 = 'C17';
    case C18 = 'C18';
    case C19 = 'C19';
    case C20 = 'C20';
    case C21 = 'C21';
    case C22 = 'C22';
    case C23 = 'C23';
    case C24 = 'C24';
    case C25 = 'C25';
    case C26 = 'C26';
    case C27 = 'C27';
    case C28 = 'C28';
    case C29 = 'C29';
    case C30 = 'C30';
    case C31 = 'C31';

    protected function labelKeyPrefix(): ?string
    {
        return 'report.standard.indicator.child';
    }

    public function class(): string
    {
        return "\\App\\Reports\\Standard\\Child\\{$this->value}";
    }
}
