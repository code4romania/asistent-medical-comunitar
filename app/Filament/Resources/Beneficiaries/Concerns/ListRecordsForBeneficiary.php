<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Concerns;

use App\Concerns\InteractsWithBeneficiary;
use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Models\Beneficiary;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait ListRecordsForBeneficiary
{
    use InteractsWithBeneficiary;
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

        $this->resolveBeneficiary(request()->record);

        abort_unless(static::getResource()::canView($this->getBeneficiary()), 403);

        abort_unless($this->getBeneficiary()->isRegular(), 404);
    }
}
