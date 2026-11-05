<?php

declare(strict_types=1);

namespace App\Rules;

use alcea\cnp\Cnp;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ValidCNP implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string):PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! Cnp::validate($value)) {
            $fail(__('validation.cnp'));
        }
    }
}
