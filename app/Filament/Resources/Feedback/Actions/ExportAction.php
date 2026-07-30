<?php

declare(strict_types=1);

namespace App\Filament\Resources\Feedback\Actions;

use App\Exports\FeedbackExport;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;

class ExportAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'export';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->authorize('export');

        $this->label(__('feedback.action.export'));

        $this->icon(Heroicon::OutlinedArrowDownTray);

        $this->color('gray');

        $this->action(
            fn () => (new FeedbackExport)
                ->download('sesizari-' . now()->toDateString() . '.xlsx')
        );
    }
}
