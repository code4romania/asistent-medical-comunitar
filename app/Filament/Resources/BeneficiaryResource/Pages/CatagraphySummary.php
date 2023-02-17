<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Concerns\Beneficiary\SidebarLayout;
use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource;
use App\Forms\Components\Card;
use Filament\Forms\Components\View;
use Filament\Pages\Actions;
use Filament\Resources\Form;
use Filament\Resources\Pages\ViewRecord;

class CatagraphySummary extends ViewRecord implements WithSidebar
{
    use SidebarLayout;

    protected static string $resource = BeneficiaryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return $this->getRecord()->full_name;
    }

    protected function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Card::make()
                    ->heading(__('catagraphy.header.vulnerabilities'))
                    ->schema([
                        View::make('vendor.tables.components.empty-state.index')
                            ->viewData([
                                'icon' => 'icon-empty-state',
                                'heading' => 'Vulnerabilități indisponibile',
                                'description' => 'Inventore error aliquid provident iste voluptas hic.',
                            ]),
                    ]),

                Card::make()
                    ->heading(__('catagraphy.header.recommendations'))
                    ->schema([
                        View::make('vendor.tables.components.empty-state.index')
                            ->viewData([
                                'icon' => 'icon-empty-state',
                                'heading' => 'Recomandări indisponibile',
                                'description' => 'Inventore error aliquid provident iste voluptas hic.',
                            ]),
                    ]),
            ]);
    }
}
