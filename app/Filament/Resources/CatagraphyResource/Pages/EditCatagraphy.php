<?php

declare(strict_types=1);

namespace App\Filament\Resources\CatagraphyResource\Pages;

use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\CatagraphyResource;
use App\Filament\Resources\CatagraphyResource\Concerns\ResolvesRecord;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditCatagraphy extends EditRecord
{
    use ResolvesRecord;

    protected static string $resource = CatagraphyResource::class;

    protected function getActions(): array
    {
        return [
        ];
    }

    protected function getBreadcrumbs(): array
    {
        return [];
    }

    protected function getRedirectUrl(): string
    {
        return BeneficiaryResource::getUrl('catagraphy.view', $this->record);
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->fill($data)->save();

        return $record;
    }
}
