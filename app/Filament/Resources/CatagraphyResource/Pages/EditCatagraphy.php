<?php

declare(strict_types=1);

namespace App\Filament\Resources\CatagraphyResource\Pages;

use App\Contracts\Forms\FixedActionBar;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\CatagraphyResource;
use App\Filament\Resources\CatagraphyResource\Concerns;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditCatagraphy extends EditRecord implements FixedActionBar
{
    use Concerns\ResolvesRecord;
    use Concerns\HasRecordBreadcrumb;

    protected static string $resource = CatagraphyResource::class;

    protected function getActions(): array
    {
        return [
        ];
    }

    public function getTitle(): string
    {
        return __('catagraphy.form.edit');
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }

    protected function getRedirectUrl(): string
    {
        return BeneficiaryResource::getUrl('catagraphy.view', $this->getBeneficiary());
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->fill($data)->save();

        return $record;
    }
}
