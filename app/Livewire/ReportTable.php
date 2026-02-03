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
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
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
        if (filled($this->columns)) {
            return collect($this->columns)
                ->when(
                    $this->type->is(Type::STATISTIC),
                    fn (Collection $columns) => $columns
                        ->prepend([
                            'name' => 'indicator',
                            'label' => 'Indicator',
                        ])
                )
                ->map(function (array $column) {
                    $label = data_get($column, 'label');
                    $suffix = data_get($column, 'suffix');

                    if (filled($suffix)) {
                        $label .= '<small class="block">(' . $suffix . ')</small>';
                    }

                    return TextColumn::make($column['name'])
                        ->label(new HtmlString($label))
                        ->alignment(match ($column['name']) {
                            'id' => Alignment::End,
                            default => Alignment::Start,
                        })
                        ->wrap();
                })
                ->all();
        }

        return collect([
            [
                'name' => 'indicator',
                'label' => 'Indicator',
            ],
            [
                'name' => '0',
                'label' => 'Valoare',
            ],
        ])
            ->map(
                fn (array $column) => TextColumn::make($column['name'])
                    ->label(ucfirst($column['label']))
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
                'indicator' => $indicator,
                ...$values,
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
