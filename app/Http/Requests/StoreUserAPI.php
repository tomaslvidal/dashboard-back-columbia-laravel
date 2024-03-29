<?php

namespace Columbia\Http\Requests;

use Columbia\Rules\Telephone;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule
;


class StoreUserAPI extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $return = array(
            'password' => 'string|max:30',
            'name' => 'string|max:30',
            'last_name' => 'string|max:30',
            'email' => 'email|unique:users,email,'.$this->id,
            'telephone' => ['string', 'nullable', new Telephone]
        );

        if($this->method()!="PUT" && $this->method()!="PATCH"){
            foreach ($return as $key => $value) {
                if($key!="telephone"){
                    $return[$key] = $value."|required";
                }
            }
        }

        return $return;
    }
}
