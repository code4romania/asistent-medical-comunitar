<?php

declare(strict_types=1);

namespace App\Filament\Resources\Documents\Actions;

use App\Filament\Resources\Documents\DocumentResource;
use App\Models\Document;
use Filament\Actions\CreateAction;

class CreateDocumentAction extends CreateAction
{
    public static function getDefaultName(): ?string
    {
        return 'create_document';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('document.action.create'));

        $this->modalHeading(__('document.action.create'));

        $this->icon('heroicon-o-plus-circle');

        $this->groupedIcon(null);

        $this->createAnother(false);

        $this->using(function (array $data, $livewire) {
            $data['beneficiary_id'] = $livewire->getBeneficiary()?->id;

            return Document::create($data);
        });

        $this->schema(DocumentResource::getFormSchema());
    }
}
