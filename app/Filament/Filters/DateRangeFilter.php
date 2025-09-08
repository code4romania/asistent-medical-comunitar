<?php

declare(strict_types=1);

namespace App\Filament\Filters;

use Carbon\Carbon;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class DateRangeFilter extends Filter
{
    public string $formComponent = Checkbox::class;

    protected function setUp(): void
    {
        parent::setUp();

        $this->schema([
            DatePicker::make('date_from')
                ->label(__('app.filter.date_from'))
                ->placeholder(
                    fn (): string => today()
                        ->subYear()
                        ->toFormattedDate()
                ),

            DatePicker::make('date_until')
                ->label(__('app.filter.date_until'))
                ->placeholder(
                    fn (): string => today()
                        ->toFormattedDate()
                ),
        ]);

        $this->query(function (Builder $query, array $state) {
            return $query
                ->when(data_get($state, 'date_from'), function (Builder $query, string $date) {
                    $query->whereDate('created_at', '>=', $date);
                })
                ->when(data_get($state, 'date_until'), function (Builder $query, string $date) {
                    $query->whereDate('created_at', '<=', $date);
                });
        });

        $this->indicateUsing(function (array $state): array {
            return collect(['date_from', 'date_until'])
                ->mapWithKeys(function (string $filter) use ($state) {
                    $value = data_get($state, $filter);

                    if (! \is_null($value)) {
                        $value = __('app.filter.date_from', [
                            'date' => Carbon::parse($value)->toFormattedDate(),
                        ]);
                    }

                    return [$filter => $value];
                })
                ->filter()
                ->all();
        });
    }
}
