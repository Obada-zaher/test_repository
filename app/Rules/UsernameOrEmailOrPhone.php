<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UsernameOrEmailOrPhone implements Rule
{
    public function passes($attribute, $value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) ||
               preg_match('/^[0-9]+$/', $value) ||
               preg_match('/^[a-zA-Z0-9_.]+$/', $value);
    }

    public function message()
    {
        return 'The :attribute must be a valid email, phone number, or username.';
    }
}
