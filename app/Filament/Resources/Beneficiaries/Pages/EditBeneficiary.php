<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Pages;

use App\Filament\Resources\Beneficiaries\Concerns\HasActions;
use App\Filament\Resources\Beneficiaries\Concerns\HasRecordBreadcrumb;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use App\Contracts\Forms\FixedActionBar;
use App\Enums\Beneficiary\ReasonRemoved;
use App\Enums\Beneficiary\Status;
use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Filament\Resources\Beneficiaries\Schemas\OcasionalBeneficiaryForm;
use App\Filament\Resources\Beneficiaries\Schemas\RegularBeneficiaryForm;
use App\Forms\Components\BeneficiaryProgram;
use App\Forms\Components\Select;
use App\Models\User;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Builder;

class EditBeneficiary extends EditRecord implements FixedActionBar
{
    use HasActions;
    use HasRecordBreadcrumb;

    protected static string $resource = BeneficiaryResource::class;

    public function mount(int | string $record): void
    {
        parent::mount($record);

        $this->resolveBeneficiary($record);
    }

    public function getTitle(): string
    {
        return $this->getRecord()->full_name ?? __('field.has_unknown_identity');
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }

    public function form(Schema $schema): Schema
    {
        if ($this->getRecord()->isRegular()) {
            return $schema
                ->columns(1)
                ->components([
                    Section::make()
                        ->heading(__('beneficiary.section.program'))
                        ->schema([
                            Placeholder::make('id')
                                ->label(__('field.beneficiary_id')),

                            Placeholder::make('type')
                                ->label(__('field.beneficiary_type')),

                            Select::make('nurse_id')
                                ->label(__('field.allocated_nurse'))
                                ->relationship('nurse', 'full_name', fn (Builder $query) => $query->onlyNurses())
                                ->getOptionLabelFromRecordUsing(fn (User $record) => "#{$record->id} {$record->full_name}")
                                ->disabled()
                                ->searchable()
                                ->preload(),

                            Select::make('integrated')
                                ->label(__('field.integrated'))
                                ->boolean(
                                    trueLabel: __('beneficiary.integrated.yes'),
                                    falseLabel: __('beneficiary.integrated.no'),
                                )
                                ->formatStateUsing(fn (bool $state) => (int) $state)
                                ->required(),

                            Select::make('status')
                                ->label(__('field.current_status'))
                                ->placeholder(__('placeholder.choose'))
                                ->options(Status::options())
                                ->enum(Status::class)
                                ->live()
                                ->required(),

                            Grid::make('status_reason')
                                ->columns()
                                ->visible(fn (Get $get) => Status::REMOVED->is($get('status')))
                                ->schema([
                                    Select::make('reason_removed')
                                        ->label(__('field.reason_removed'))
                                        ->placeholder(__('placeholder.choose'))
                                        ->options(ReasonRemoved::options())
                                        ->live()
                                        ->required(),

                                    TextInput::make('reason_removed_notes')
                                        ->label(__('field.reason_removed_notes'))
                                        ->maxLength(200)
                                        ->required(fn (Get $get) => ReasonRemoved::OTHER->is($get('reason_removed'))),
                                ]),
                        ]),
                    // BeneficiaryProgram::make(),

                    Section::make()
                        ->heading(__('beneficiary.section.personal_data'))
                        ->schema(RegularBeneficiaryForm::getSchema()),
                ]);
        }

        return $schema
            ->columns(1)
            ->components([
                Section::make()
                    ->heading(__('beneficiary.section.personal_data'))
                    ->schema(OcasionalBeneficiaryForm::getSchema()),
            ]);
    }

    public function getRelationManagers(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getRedirectUrl(): string
    {
        if ($this->getRecord()->isRegular()) {
            return static::getResource()::getUrl('personal_data', $this->getRecord());
        }

        return static::getResource()::getUrl('view', $this->getRecord());
    }
}
