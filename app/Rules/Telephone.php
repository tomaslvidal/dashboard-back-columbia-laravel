<?php

namespace Columbia\Rules;

use Illuminate\Contracts\Validation\Rule;

class Telephone implements Rule
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
        if(preg_match("/^\+?(\d|\-)+$/", $value) && strlen($value) <= 15){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Ingresa un numero telefonico valido.';
    }
}
