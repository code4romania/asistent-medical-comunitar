<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Forms\Components\Badge;
use App\Forms\Components\Card;
use App\Forms\Components\Location;
use App\Forms\Components\Subsection;
use App\Forms\Components\Value;
use App\Models\Beneficiary;
use Filament\Resources\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewPersonalData extends ViewRecord implements WithSidebar
{
    use Concerns\HasActions;
    use Concerns\HasRecordBreadcrumb;
    use Concerns\HasSidebar;

    protected static string $resource = BeneficiaryResource::class;

    public function getTitle(): string
    {
        return __('beneficiary.section.personal_data');
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }

    protected function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Card::make()
                    ->header(__('beneficiary.header.id'))
                    ->schema([
                        Badge::make('type')
                            ->color('text-indigo-800 bg-indigo-100')
                            ->content(fn (Beneficiary $record) => $record->type->label()),

                        Subsection::make()
                            ->icon('heroicon-o-user')
                            ->columns(2)
                            ->schema([
                                Value::make('first_name')
                                    ->label(__('field.first_name')),
                                Value::make('last_name')
                                    ->label(__('field.last_name')),
                                Value::make('gender')
                                    ->label(__('field.gender')),
                                Value::make('cnp')
                                    ->label(__('field.cnp')),
                            ]),

                        Subsection::make()
                            ->icon('heroicon-o-user-group')
                            ->columns(2)
                            ->schema([
                                Value::make('household')
                                    ->label(__('field.household')),
                                Value::make('family')
                                    ->label(__('field.family')),
                            ]),

                        Subsection::make()
                            ->icon('heroicon-o-location-marker')
                            ->columns(2)
                            ->schema([
                                Location::make(),
                                Value::make('address')
                                    ->label(__('field.address')),
                                Value::make('phone')
                                    ->label(__('field.phone')),
                            ]),

                        Subsection::make()
                            ->icon('heroicon-o-annotation')
                            ->schema([
                                Value::make('notes')
                                    ->label(__('field.beneficiary_notes'))
                                    ->extraAttributes(['class' => 'prose max-w-none']),
                            ]),
                    ]),
            ]);
    }
}
