<?php

declare(strict_types=1);

namespace App\Filament\Forms\Components;

use App\Models\ICD10AM\ICD10AMDiagnostic;
use Filament\Forms\Components\Select;

class ICD10AMDiagnosticSelect extends Select
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->searchable();

        $this->relationship('diagnostic', 'name');

        $this->getSearchResultsUsing(function (string $search) {
            return ICD10AMDiagnostic::query()
                ->where('name', 'like', "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%")
                ->limit($this->getOptionsLimit())
                ->get()
                ->mapWithKeys(fn (ICD10AMDiagnostic $diagnostic) => [
                    $diagnostic->getKey() => static::getRenderedOptionLabel($diagnostic),
                ]);
        });

        $this->getOptionLabelUsing(
            fn ($value) => static::getRenderedOptionLabel(ICD10AMDiagnostic::find($value))
        );

        $this->helperText(__('field.optional'));
    }

    public static function getRenderedOptionLabel(?ICD10AMDiagnostic $model): ?string
    {
        if (\is_null($model)) {
            return null;
        }

        return $model->id . ' - ' . $model->name;
    }
}
