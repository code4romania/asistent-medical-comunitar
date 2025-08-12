<?php

declare(strict_types=1);

namespace App\Forms\Components;

use App\Models\Orpha\OrphaDiagnostic;
use Filament\Forms\Components\Select;

class OrphaDiagnosticSelect extends Select
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->searchable();

        $this->relationship('orphaDiagnostic', 'name');

        $this->getSearchResultsUsing(function (string $search) {
            return OrphaDiagnostic::query()
                ->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%")
                ->limit($this->getOptionsLimit())
                ->get()
                ->mapWithKeys(fn (OrphaDiagnostic $diagnostic) => [
                    $diagnostic->getKey() => static::getRenderedOptionLabel($diagnostic),
                ]);
        });

        $this->getOptionLabelUsing(
            fn ($value) => static::getRenderedOptionLabel(OrphaDiagnostic::find($value))
        );

        $this->helperText(__('field.optional'));
    }

    public static function getRenderedOptionLabel(?OrphaDiagnostic $model): ?string
    {
        if (\is_null($model)) {
            return null;
        }

        return $model->code . ' - ' . $model->name;
    }
}
