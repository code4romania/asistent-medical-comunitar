<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Enums\Beneficiary\ReasonRemoved;
use App\Enums\Beneficiary\Status;
use App\Filament\Resources\AppointmentResource\Schemas\RegularBeneficiaryInfolist;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Infolists\Components\BooleanEntry;
use App\Models\Beneficiary;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewPersonalData extends ViewRecord
{
    use Concerns\HasActions;
    use Concerns\HasRecordBreadcrumb;

    protected static string $resource = BeneficiaryResource::class;

    public function mount(int | string $record): void
    {
        parent::mount($record);

        $this->resolveBeneficiary($record);
    }

    public function getTitle(): string
    {
        return __('beneficiary.section.personal_data');
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()
                    ->heading(__('beneficiary.section.program'))
                    ->columns()
                    ->schema([
                        TextEntry::make('id')
                            ->label(__('field.beneficiary_id')),

                        TextEntry::make('type')
                            ->label(__('field.beneficiary_type'))
                            ->badge(),

                        TextEntry::make('status')
                            ->label(__('field.current_status'))
                            ->badge(),

                        TextEntry::make('reason_removed')
                            ->visible(fn (Beneficiary $record) => Status::REMOVED->is($record->status))
                            ->label(__('field.reason_removed'))
                            ->formatStateUsing(function (Beneficiary $record) {
                                $parts = [];

                                if ($record->reason_removed instanceof ReasonRemoved) {
                                    $parts[] = $record->reason_removed->getLabel();
                                }

                                if (filled($record->reason_removed_notes)) {
                                    $parts[] = "({$record->reason_removed_notes})";
                                }

                                return implode(' ', $parts);
                            }),

                        TextEntry::make('nurse.full_name')
                            ->label(__('field.allocated_nurse'))
                            ->prefix(fn (Beneficiary $record) => "#{$record->nurse->id} "),

                        BooleanEntry::make('integrated')
                            ->label(__('field.integrated')),
                    ]),

                Section::make()
                    ->heading(__('beneficiary.header.id'))
                    ->headerActions([
                        Action::make('view')
                            ->label(__('filament-actions::edit.single.label'))
                            ->icon('heroicon-s-pencil')
                            ->url(BeneficiaryResource::getUrl('edit', [
                                'record' => $this->getRecord(),
                            ])),
                    ])
                    ->schema(RegularBeneficiaryInfolist::getSchema()),
            ]);
    }

    public function getRelationManagers(): array
    {
        return [];
    }
}
