<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EnumRule implements ValidationRule
{
    protected $enumClass;

    public function __construct($enumClass)
    {
        $this->enumClass = $enumClass;
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (in_array(needle: $value, haystack: (new $this->enumClass)->getValues(), strict: true)) {
            $fail($this->message());
        }
    }

    public function message()
    {
        return trans(key: 'app.general.rules.enum-rules');
    }
}
