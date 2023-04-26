<?php

declare(strict_types=1);

namespace App\Filament\Resources\CatagraphyResource\Pages;

use App\Contracts\Forms\FixedActionBar;
use App\Enums\Beneficiary\Status;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\CatagraphyResource;
use App\Filament\Resources\CatagraphyResource\Concerns;
use App\Models\Vulnerability\Vulnerability;
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

    public function mount($record): void
    {
        parent::mount($record);

        abort_unless($this->getBeneficiary()->isRegular(), 404);
    }

    protected function getRedirectUrl(): string
    {
        return BeneficiaryResource::getUrl('catagraphy.view', $this->getBeneficiary());
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Handle pregnancy data
        if (! Vulnerability::isPregnancy($data['cat_rep'])) {
            $data['cat_preg'] = null;
        }

        // Handle disability data
        if (! Vulnerability::isValid($data['cat_diz'])) {
            $data['cat_diz_tip'] = null;
            $data['cat_diz_gr'] = null;
        }

        $record->fill($data)->save();

        if ($record->beneficiary->status->is(Status::REGISTERED)) {
            $record->beneficiary->changeStatus(Status::CATAGRAPHED);
        }

        return $record;
    }
}
