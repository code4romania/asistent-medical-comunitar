<?php

declare(strict_types=1);

namespace App\Filament\Resources\ReportResource\Actions;

use App\Exports\ReportExport;
use App\Models\Report;
use Filament\Pages\Actions\Action;

class ExportAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'export';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('report.action.export'));

        $this->icon('heroicon-o-download');

        $this->color('secondary');

        $this->keyBindings(['mod+e']);

        $this->action(
            fn (Report $record) => (new ReportExport($record))
                ->download("{$record->title}.xlsx")
        );
    }
}
