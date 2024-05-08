<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidOrderStatusRule implements ValidationRule {
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void {
        if (!in_array($value, ['pending', 'processing', 'completed', 'cancelled'])) {
            $fail("The $attribute must be one of: pending, processing, completed, cancelled.");
        }
    }
}
