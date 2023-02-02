<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Concerns\BeneficiarySidebar;
use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPersonalDataBeneficiary extends EditRecord implements WithSidebar
{
    use BeneficiarySidebar;

    protected static string $resource = BeneficiaryResource::class;

    protected function getActions(): array
    {
        return [
            // Actions\ViewAction::make(),
            // Actions\DeleteAction::make(),
        ];
    }
}
