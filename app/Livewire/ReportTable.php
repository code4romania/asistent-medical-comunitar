<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Enums\Report\Type;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\Alignment;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class ReportTable extends Component implements HasActions, HasForms, HasTable
{
    use InteractsWithActions;
    use InteractsWithForms;
    use InteractsWithTable;

    public Type $type;

    public string $title;

    public array | null $columns = null;

    public array $data = [];

    public function getColumns(): array
    {
        if ($this->type->is(Type::LIST)) {
            return collect($this->columns)
                ->map(
                    fn (array $column) => TextColumn::make($column['name'])
                        ->label($column['label'])
                        ->alignment(match ($column['name']) {
                            'id' => Alignment::End,
                            default => Alignment::Start,
                        })
                        ->wrap()
                )
                ->all();
        }

        return collect(['Indicator', 'Valoare'])
            ->map(
                fn (string $column) => TextColumn::make($column)
                    ->wrap()
            )
            ->all();
    }

    public function getRecords(): array
    {
        if ($this->type->is(Type::LIST)) {
            return $this->data;
        }

        return collect($this->data)
            ->map(fn (array $values, string $indicator) => [
                'Indicator' => $indicator,
                'Valoare' => $values[0],
            ])
            ->values()
            ->all();
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading($this->title)
            ->records(fn () => $this->getRecords())
            ->columns($this->getColumns())
            ->recordUrl(fn (array $record): ?string => collect(data_get($record, 'actions'))->keys()->first())
            ->recordActions([
                Action::make('view')
                    ->visible(fn (array $record) => filled(data_get($record, 'actions')))
                    ->label(fn (array $record): string => collect(data_get($record, 'actions'))->values()->first())
                    ->url(fn (array $record): ?string => collect(data_get($record, 'actions'))->keys()->first()),

            ])
            ->emptyStateHeading(__('report.no-results.title'))
            ->emptyStateDescription(__('report.no-results.description'))
            ->emptyStateIcon(Heroicon::OutlinedXMark);
    }

    public function render(): string
    {
        return <<<'BLADE'
            <div>{{ $this->table }}</div>
        BLADE;
    }
}
