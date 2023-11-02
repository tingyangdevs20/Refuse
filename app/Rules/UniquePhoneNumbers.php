<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniquePhoneNumbers implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Perform your custom validation logic here
        return !DB::table('contacts')
            ->where(function ($query) use ($value) {
                $query->where('number', $value)
                    ->orWhere('number2', $value)
                    ->orWhere('number3', $value);
            })
            ->exists();
    }


    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The phone number already exists!';
    }
}
