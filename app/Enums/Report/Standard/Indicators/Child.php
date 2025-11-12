<?php

declare(strict_types=1);

namespace App\Enums\Report\Standard\Indicators;

use App\Contracts\Enums\HasQuery;
use CommitGlobal\Enums\Concerns\Arrayable;
use CommitGlobal\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum Child: string implements HasQuery, HasLabel
{
    use Arrayable;
    use Comparable;

    case C01 = 'C01';
    case C02 = 'C02';
    // case C03 = 'C03'; // not implemented
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

    public function getLabel(): ?string
    {
        return match ($this) {
            self::C01 => __('report.standard.indicator.child.C01'),
            self::C02 => __('report.standard.indicator.child.C02'),
            // self::C03 => __('report.standard.indicator.child.C03'),
            self::C04 => __('report.standard.indicator.child.C04'),
            self::C05 => __('report.standard.indicator.child.C05'),
            self::C06 => __('report.standard.indicator.child.C06'),
            self::C07 => __('report.standard.indicator.child.C07'),
            self::C08 => __('report.standard.indicator.child.C08'),
            self::C09 => __('report.standard.indicator.child.C09'),
            self::C10 => __('report.standard.indicator.child.C10'),
            self::C11 => __('report.standard.indicator.child.C11'),
            self::C12 => __('report.standard.indicator.child.C12'),
            self::C13 => __('report.standard.indicator.child.C13'),
            self::C14 => __('report.standard.indicator.child.C14'),
            self::C15 => __('report.standard.indicator.child.C15'),
            self::C16 => __('report.standard.indicator.child.C16'),
            self::C17 => __('report.standard.indicator.child.C17'),
            self::C18 => __('report.standard.indicator.child.C18'),
            self::C19 => __('report.standard.indicator.child.C19'),
            self::C20 => __('report.standard.indicator.child.C20'),
            self::C21 => __('report.standard.indicator.child.C21'),
            self::C22 => __('report.standard.indicator.child.C22'),
            self::C23 => __('report.standard.indicator.child.C23'),
            self::C24 => __('report.standard.indicator.child.C24'),
            self::C25 => __('report.standard.indicator.child.C25'),
            self::C26 => __('report.standard.indicator.child.C26'),
            self::C27 => __('report.standard.indicator.child.C27'),
            self::C28 => __('report.standard.indicator.child.C28'),
            self::C29 => __('report.standard.indicator.child.C29'),
            self::C30 => __('report.standard.indicator.child.C30'),
            self::C31 => __('report.standard.indicator.child.C31'),
        };
    }

    public function class(): string
    {
        return "\\App\\Reports\\Queries\\Child\\{$this->value}";
    }
}
