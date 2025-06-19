<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueAttributes implements ValidationRule
{

    public function __construct(
        private string $table,
        private array $attributes,
        private mixed $id = null
    ) {
        //
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = DB::table($this->table)->where($attribute, $value);

        foreach ($this->attributes as $attr => $val) {
            $query->where($attr, $val);
        }

        if ($this->id) {
            $query->where('id', '!=', $this->id);
        }

        if ($query->exists()) {
            $fail('The :attribute has already been taken.');
        }
    }
}
