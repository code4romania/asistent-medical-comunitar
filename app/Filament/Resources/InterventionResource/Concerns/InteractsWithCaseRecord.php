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

    protected function resolveRecord($key): CaseManagement
    {
        $record = app(CaseManagement::class)
            ->resolveRouteBindingQuery($this->record->cases(), $key)
            ->first();

        if ($record === null) {
            throw (new ModelNotFoundException())->setModel(CaseManagement::class, [$key]);
        }

        return $record;
    }

    public function mount(...$args): void
    {
        static::authorizeResourceAccess();

        [$record, $intervention] = $args;

        $this->record = BeneficiaryResource::resolveRecordRouteBinding($record);

        $this->intervention = $this->resolveRecord($intervention->id);
    }
}
