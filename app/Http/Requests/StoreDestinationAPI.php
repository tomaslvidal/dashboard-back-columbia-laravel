<?php

namespace Columbia\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDestinationAPI extends FormRequest
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
            'title' => 'string|max:60',
            'subtitle' => 'string|max:60',
            'image1' => 'file|image|max:600',
            'image2' => 'file|image|max:600',
            'image3' => 'file|image|max:600',
            'image4' => 'file|image|max:600',
        );

        if($this->method()!="PUT" && $this->method()!="PATCH"){
            foreach ($return as $key => $value) {
                if($key!="description" && $key!="image1" && $key!="image2" && $key!="image3" && $key!="image4"){
                    $return[$key] = $value."|required";
                }
            }
        }

        return $return;
    }
}
