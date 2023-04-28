<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Concerns;

use App\Filament\Resources\BeneficiaryResource;
use App\Models\Beneficiary;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait InteractsWithBeneficiaryRecord
{
    use InteractsWithRecord;

    protected function resolveRecord($key): Beneficiary
    {
        $record = BeneficiaryResource::resolveRecordRouteBinding($key);

        if ($record === null) {
            throw (new ModelNotFoundException())->setModel(Beneficiary::class, [$key]);
        }

        return $record;
    }

    public function mount(): void
    {
        static::authorizeResourceAccess();

        $this->record = $this->resolveRecord(request()->record);

        abort_unless(static::getResource()::canView($this->getRecord()), 403);

        abort_unless($this->getRecord()->isRegular(), 404);
    }
}
