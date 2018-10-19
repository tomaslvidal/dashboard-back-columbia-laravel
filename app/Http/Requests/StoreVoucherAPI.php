<?php

namespace Columbia\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Columbia\Rules\fileExtension;

class StoreVoucherAPI extends FormRequest
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
            'name' => 'string|max:30',
            'description' => 'string|max:191',
            'file_name' => ['file', new fileExtension],
        );

        if($this->method()!="PUT" && $this->method()!="PATCH"){
            foreach ($return as $key => $value){
                if($key!="file_name"){
                    $return[$key] = $value."|required";
                }
            }
        }

        return $return;
    }
}
