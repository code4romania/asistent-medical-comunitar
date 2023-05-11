<?php

declare(strict_types=1);

namespace App\Filament\Resources\InterventionResource\Concerns;

use App\Filament\Resources\BeneficiaryResource;
use App\Models\Beneficiary;
use App\Models\Intervention\CaseManagement;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait InteractsWithCaseRecord
{
    use InteractsWithRecord;

    public Beneficiary $beneficiary;

    protected function resolveRecord($key): Beneficiary
    {
        $record = app(CaseManagement::class)
            ->resolveRouteBindingQuery($this->beneficiary->cases(), $key)
            ->first();

        if ($record === null) {
            throw (new ModelNotFoundException())->setModel(CaseManagement::class, [$key]);
        }

        return $record;
    }

    public function mount(): void
    {
        static::authorizeResourceAccess();

        $this->beneficiary = BeneficiaryResource::resolveRecordRouteBinding(
            request()->record
        );

        $this->record = $this->resolveRecord(request()->record);

    }
}
