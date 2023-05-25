<?php

declare(strict_types=1);

namespace App\Enums\Report;

use App\Concerns;

enum Type: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;
    use Concerns\Enums\HasLabel;

    case NURSE_ACTIVITY = 'nurse_activity';
    case VULN_TOTAL = 'vuln_total';
    case VULN_LIST = 'vuln_list';
    case HEALTH_TOTAL = 'health_total';
    case HEALTH_LIST = 'health_list';

    protected function labelKeyPrefix(): ?string
    {
        return 'report.type';
    }
}
