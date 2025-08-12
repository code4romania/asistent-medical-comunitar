<?php

declare(strict_types=1);

namespace App\Forms\Components;

use App\Enums\Beneficiary\ReasonRemoved;
use App\Enums\Beneficiary\Status;
use App\Models\Beneficiary;
use App\Models\User;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Contracts\Database\Eloquent\Builder;

class BeneficiaryProgram extends Section
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->header(__('beneficiary.section.program'))
            ->columns(2);
    }

    public function getChildComponents(): array
    {
        return match ($this->getContainer()->getContext()) {
            'view' => $this->getViewComponents(),
            default => $this->getEditComponents(),
        };
    }

    protected function getViewComponents(): array
    {
        return [

            Value::make('id')
                ->label(__('field.beneficiary_id')),

            Value::make('type')
                ->label(__('field.beneficiary_type')),

            Value::make('status')
                ->label(__('field.current_status')),

            Value::make('reason_removed')
                ->visible(fn (callable $get) => Status::REMOVED->is($get('status')))
                ->label(__('field.reason_removed'))
                ->content(function (Beneficiary $record) {
                    $parts = [];

                    if ($record->reason_removed instanceof ReasonRemoved) {
                        $parts[] = $record->reason_removed->label();
                    }

                    if (filled($record->reason_removed_notes)) {
                        $parts[] = "({$record->reason_removed_notes})";
                    }

                    return implode(' ', $parts);
                }),

            Value::make('nurse')
                ->label(__('field.allocated_nurse'))
                ->content(fn (Beneficiary $record) => "#{$record->nurse->id} {$record->nurse->full_name}"),

            Value::make('integrated')
                ->label(__('field.integrated'))
                ->boolean(),

        ];
    }

    protected function getEditComponents(): array
    {
        return [
            Value::make('id')
                ->label(__('field.beneficiary_id')),

            Value::make('type')
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
                ->reactive()
                ->required(),

            Grid::make('status_reason')
                ->columns()
                ->visible(fn (callable $get) => Status::REMOVED->is($get('status')))
                ->schema([
                    Select::make('reason_removed')
                        ->label(__('field.reason_removed'))
                        ->placeholder(__('placeholder.choose'))
                        ->options(ReasonRemoved::options())
                        ->reactive()
                        ->required(),

                    TextInput::make('reason_removed_notes')
                        ->label(__('field.reason_removed_notes'))
                        ->maxLength(200)
                        ->required(fn (callable $get) => ReasonRemoved::OTHER->is($get('reason_removed'))),
                ]),

        ];
    }
}
