<?php

declare(strict_types=1);

namespace App\Filament\Resources\Reports\Pages;

use App\Filament\Resources\Reports\Actions\ExportAction;
use App\Filament\Resources\Reports\ReportResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;

class ViewReport extends ViewRecord
{
    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make(),

            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return $this->getRecord()->title;
    }
}
