<?php

namespace Columbia\Rules;

use Illuminate\Contracts\Validation\Rule;

class fileExtension implements Rule
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
        if($value->getClientOriginalExtension()=="exe" || $value->getClientOriginalExtension()=="bat"){
            return false;
        }
        else{
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'File extension not allowed';
    }
}
