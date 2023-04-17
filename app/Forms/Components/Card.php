<?php

declare(strict_types=1);

namespace App\Forms\Components;

use App\Concerns\Forms\HasComponentActions;
use App\Concerns\Forms\HasFooter;
use App\Concerns\Forms\HasHeader;
use Filament\Forms\Components\Card as BaseCard;

class Card extends BaseCard
{
    use HasComponentActions;
    use HasFooter;
    use HasHeader;

    protected string $view = 'forms.components.card';
}
