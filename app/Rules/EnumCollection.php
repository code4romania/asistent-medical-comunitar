<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rules\Enum;

class EnumCollection implements ValidationRule
{
    /**
     * The enum validation rule.
     *
     * @var Enum
     */
    protected Enum $rule;

    /**
     * Create a new rule instance.
     *
     * @param  string $type
     * @return void
     */
    public function __construct(string $type)
    {
        $this->rule = new Enum($type);
    }

    /**
     * Run the validation rule.
     *
     * @param Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach (Arr::wrap($value) as $item) {
            if ($this->rule->passes($attribute, $item)) {
                continue;
            }

            $fail(__('validation.enum'));
        }
    }
}
