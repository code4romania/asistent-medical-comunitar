<?php

declare(strict_types=1);

namespace App\Filament\Resources\Appointments\Pages;

use App\Filament\Resources\Appointments\AppointmentResource;
use Filament\Resources\Pages\CreateRecord;
use Livewire\Attributes\Url;

class CreateAppointment extends CreateRecord
{
    protected static string $resource = AppointmentResource::class;

    #[Url]
    public ?int $beneficiary = null;

    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['nurse_id'] = auth()->id();

        return $data;
    }

    protected function afterFill(): void
    {
        if (blank($this->beneficiary)) {
            return;
        }

        $this->form->fill([
            'beneficiary_id' => $this->beneficiary,
        ]);
    }
}
