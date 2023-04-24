<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class MultipleIn implements ValidationRule
{
    protected Collection $allowedValues;

    /**
     * Create a new rule instance.
     *
     * @param  iterable $allowedValues
     * @return void
     */
    public function __construct(iterable $allowedValues)
    {
        $this->allowedValues = collect($allowedValues);
    }

    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach (Arr::wrap($value) as $item) {
            if ($this->allowedValues->contains($item)) {
                continue;
            }

            $fail(__('validation.in'));
        }
    }
}
