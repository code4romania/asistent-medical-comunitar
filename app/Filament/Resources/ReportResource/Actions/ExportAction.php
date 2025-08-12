<?php

declare(strict_types=1);

namespace App\Filament\Resources\ReportResource\Actions;

use App\Exports\ReportExport;
use App\Models\Report;
use Filament\Actions\Action;

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

        $this->label(__('report.action.export'));

        $this->icon('heroicon-o-arrow-down-tray');

        $this->color('gray');

        $this->keyBindings(['mod+e']);

        $this->action(
            fn (Report $record) => (new ReportExport($record))
                ->download("{$record->title}.xlsx")
        );
    }
}
