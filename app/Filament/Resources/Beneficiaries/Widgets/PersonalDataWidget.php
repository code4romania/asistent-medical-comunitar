<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Widgets;

use App\Enums\Beneficiary\Status;
use App\Filament\Infolists\Components\BooleanEntry;
use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Models\Beneficiary;
use Filament\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Schemas\Schema;
use Filament\Widgets\Widget;
use Illuminate\Contracts\Support\Htmlable;

class PersonalDataWidget extends Widget implements HasForms, HasInfolists
{
    use InteractsWithForms;
    use InteractsWithInfolists;

    protected string $view = 'filament.resources.beneficiaries.widgets.personal-data';

    public Beneficiary $record;

    protected int | string | array $columnSpan = [
        'default' => 'full',
        '2xl' => 1,
    ];

    public function getHeading(): string | Htmlable | null
    {
        return __('beneficiary.section.personal_data');
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('view')
                ->label(__('beneficiary.action.view_details'))
                ->url('#')
                // ->url(BeneficiaryResource::getUrl('personal_data', ['record' => $this->record]))
                ->color('gray'),
        ];
    }

    protected function infolist(Schema $schema): Schema
    {
        return $schema
            ->record($this->record)
            ->columns()
            ->components([
                TextEntry::make('status')
                    ->hiddenLabel()
                    ->badge()
                    ->columnSpanFull(),

                TextEntry::make('reason_removed')
                    ->label(__('field.reason_removed'))
                    ->visible(fn (Beneficiary $record) => Status::REMOVED->is($record->status))
                    ->columnSpanFull(),

                TextEntry::make('id')
                    ->label(__('field.beneficiary_id')),

                BooleanEntry::make('integrated')
                    ->label(__('field.integrated')),

                TextEntry::make('household.name')
                    ->label(__('field.household')),

                TextEntry::make('family.name')
                    ->label(__('field.family')),

                TextEntry::make('age')
                    ->label(__('field.age')),

                TextEntry::make('gender')
                    ->label(__('field.gender')),

                TextEntry::make('full_address')
                    ->label(__('field.address'))
                    ->columnSpanFull(),

                TextEntry::make('phone')
                    ->label(__('field.phone'))
                    ->columnSpanFull(),
            ]);
    }
}
