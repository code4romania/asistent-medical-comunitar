<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Translation\PotentiallyTranslatedString;
use alcea\cnp\Cnp;
use Illuminate\Contracts\Validation\InvokableRule;

class ValidCNP implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string                                                                $attribute
     * @param  mixed                                                                 $value
     * @param Closure(string):PotentiallyTranslatedString $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (! Cnp::validate($value)) {
            return $fail(__('validation.cnp'));
        }
    }
}
