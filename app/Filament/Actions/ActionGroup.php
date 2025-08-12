<?php

declare(strict_types=1);

namespace App\Filament\Actions;

use Filament\Actions\ActionGroup as BaseActionGroup;

class ActionGroup extends BaseActionGroup
{
    protected string $view = 'filament.pages.actions.group';

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon('heroicon-o-chevron-down');

        $this->label(__('app.action.group'));

        $this->color('warning');
    }
}
