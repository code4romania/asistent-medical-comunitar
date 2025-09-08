<?php

declare(strict_types=1);

namespace App\Filament\Resources\Appointments\Pages;

use App\Contracts\Forms\FixedActionBar;
use App\Filament\Resources\Appointments\AppointmentResource;
use App\Models\Beneficiary;
use Filament\Resources\Pages\CreateRecord;

class CreateAppointment extends CreateRecord implements FixedActionBar
{
    protected static string $resource = AppointmentResource::class;

    public ?Beneficiary $beneficiary = null;

    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['nurse_id'] = auth()->id();

        return $data;
    }

    protected function afterFill(): void
    {
        if ($this->beneficiary === null) {
            return;
        }

        $this->form->fill([
            'beneficiary_id' => $this->beneficiary->id,
        ]);
    }
}
