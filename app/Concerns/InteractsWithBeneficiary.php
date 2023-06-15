<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Filament\Resources\BeneficiaryResource;
use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait InteractsWithBeneficiary
{
    protected ?Beneficiary $beneficiary = null;

    protected function resolveBeneficiary(mixed $key): void
    {
        if ($key instanceof Model) {
            $key = $key instanceof Beneficiary
                ? $key->id
                : null;
        }

        /** @var Beneficiary|null */
        $record = BeneficiaryResource::resolveRecordRouteBinding($key);

        if ($record === null) {
            throw (new ModelNotFoundException())->setModel(Beneficiary::class, [$key]);
        }

        $this->beneficiary = $record;
    }

    public function getBeneficiary(): Beneficiary
    {
        if (\is_null($this->beneficiary)) {
            $this->resolveBeneficiary($this->record ?? null);
        }

        return $this->beneficiary;
    }
}
