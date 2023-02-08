<?php

declare(strict_types=1);

namespace App\Tables\Columns;

use Filament\Tables\Columns\BadgeColumn as BaseColumn;
use Filament\Tables\Columns\Concerns;

class BadgeColumn extends BaseColumn
{
    use Concerns\CanFormatState;
    use Concerns\HasColors;
    use Concerns\HasIcons;

    protected string $view = 'tables.components.badge-column';
}
